'use client'

import React, { useState, useRef } from 'react'
import Image from 'next/image'

interface Seat {
  id: string
  name: string
  x: number // percentage from left
  y: number // percentage from top
  width: number // percentage
  height: number // percentage
  selected: boolean
}

interface DragState {
  isDrawing: boolean
  startX: number
  startY: number
  currentX: number
  currentY: number
}

export default function SelectTables() {
  const [seats, setSeats] = useState<Seat[]>([])
  const [hoveredSeat, setHoveredSeat] = useState<string | null>(null)
  const [dragState, setDragState] = useState<DragState>({
    isDrawing: false,
    startX: 0,
    startY: 0,
    currentX: 0,
    currentY: 0,
  })
  const [isDrawMode, setIsDrawMode] = useState(true)
  const imageRef = useRef<HTMLDivElement>(null)


  const getPercentageCoords = (e: React.MouseEvent<HTMLDivElement>) => {
    if (!imageRef.current) return null
    const rect = imageRef.current.getBoundingClientRect()
    const x = ((e.clientX - rect.left) / rect.width) * 100
    const y = ((e.clientY - rect.top) / rect.height) * 100
    return { x, y }
  }

  const handleMouseDown = (e: React.MouseEvent<HTMLDivElement>) => {
    if (!isDrawMode) return
    const coords = getPercentageCoords(e)
    if (!coords) return

    setDragState({
      isDrawing: true,
      startX: coords.x,
      startY: coords.y,
      currentX: coords.x,
      currentY: coords.y,
    })
  }

  const handleMouseMove = (e: React.MouseEvent<HTMLDivElement>) => {
    const coords = getPercentageCoords(e)
    if (!coords) return

    if (dragState.isDrawing) {
      setDragState((prev) => ({
        ...prev,
        currentX: coords.x,
        currentY: coords.y,
      }))
    } else if (!isDrawMode) {
      // Check if hovering over a seat in selection mode
      const seat = seats.find((s) => {
        return (
          coords.x >= s.x &&
          coords.x <= s.x + s.width &&
          coords.y >= s.y &&
          coords.y <= s.y + s.height
        )
      })
      setHoveredSeat(seat ? seat.id : null)
    }
  }

  const handleMouseUp = (e: React.MouseEvent<HTMLDivElement>) => {
    if (!dragState.isDrawing) return

    const coords = getPercentageCoords(e)
    if (!coords) return

    // Calculate the drawn rectangle
    const x = Math.min(dragState.startX, coords.x)
    const y = Math.min(dragState.startY, coords.y)
    const width = Math.abs(coords.x - dragState.startX)
    const height = Math.abs(coords.y - dragState.startY)

    // Only create seat if it's large enough
    if (width > 1 && height > 1) {
      const newSeat: Seat = {
        id: `seat-${Date.now()}`,
        name: `Seat ${seats.length + 1}`,
        x,
        y,
        width,
        height,
        selected: false,
      }
      setSeats((prev) => [...prev, newSeat])
    }

    setDragState({
      isDrawing: false,
      startX: 0,
      startY: 0,
      currentX: 0,
      currentY: 0,
    })
  }

  const handleMouseLeave = () => {
    if (dragState.isDrawing) {
      setDragState({
        isDrawing: false,
        startX: 0,
        startY: 0,
        currentX: 0,
        currentY: 0,
      })
    }
    setHoveredSeat(null)
  }

  const handleSeatClick = (seatId: string) => {
    if (isDrawMode) return
    setSeats((prev) =>
      prev.map((seat) =>
        seat.id === seatId ? { ...seat, selected: !seat.selected } : seat
      )
    )
  }

  const removeSeat = (seatId: string) => {
    setSeats((prev) => prev.filter((s) => s.id !== seatId))
  }

  const clearAllSeats = () => {
    setSeats([])
  }

  const renameSeat = (seatId: string, newName: string) => {
    setSeats((prev) =>
      prev.map((seat) =>
        seat.id === seatId ? { ...seat, name: newName } : seat
      )
    )
  }

  const clearSelection = () => {
    setSeats((prev) => prev.map((seat) => ({ ...seat, selected: false })))
  }

  const selectedSeats = seats.filter((s) => s.selected)

  // Get current drawing box
  const getCurrentDrawingBox = () => {
    if (!dragState.isDrawing) return null
    return {
      x: Math.min(dragState.startX, dragState.currentX),
      y: Math.min(dragState.startY, dragState.currentY),
      width: Math.abs(dragState.currentX - dragState.startX),
      height: Math.abs(dragState.currentY - dragState.startY),
    }
  }

  const currentDrawingBox = getCurrentDrawingBox()

  return (
    <div className="w-full min-h-screen bg-gray-100 p-4 md:p-8">
      <div className="max-w-6xl mx-auto">
        <div className="mb-6">
          <h1 className="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
            Interactive Seat Selector
          </h1>
          <p className="text-gray-600">
            {isDrawMode
              ? 'Draw rectangles over seats by clicking and dragging'
              : 'Click on seats to select them'}
          </p>
        </div>

        {/* Controls */}
        <div className="mb-4 flex flex-col md:flex-row gap-4 items-start md:items-center flex-wrap">
          <div className="flex gap-2">
            <button
              onClick={() => setIsDrawMode(true)}
              className={`px-4 py-2 rounded font-semibold transition-colors ${
                isDrawMode
                  ? 'bg-blue-600 text-white'
                  : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
              }`}
            >
              ✏️ Draw Mode
            </button>
            <button
              onClick={() => setIsDrawMode(false)}
              className={`px-4 py-2 rounded font-semibold transition-colors ${
                !isDrawMode
                  ? 'bg-blue-600 text-white'
                  : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
              }`}
            >
              👆 Select Mode
            </button>
          </div>

          <div className="text-sm text-gray-700">
            Total seats: <span className="font-bold">{seats.length}</span>
            {!isDrawMode && selectedSeats.length > 0 && (
              <>
                {' | '}Selected: <span className="font-bold">{selectedSeats.length}</span>
              </>
            )}
          </div>

          {seats.length > 0 && (
            <button
              onClick={clearAllSeats}
              className="px-3 py-2 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition-colors"
            >
              Clear All
            </button>
          )}

          {!isDrawMode && selectedSeats.length > 0 && (
            <button
              onClick={clearSelection}
              className="px-3 py-2 text-sm bg-orange-500 text-white rounded hover:bg-orange-600 transition-colors"
            >
              Clear Selection
            </button>
          )}
        </div>

        {/* Legend */}
        <div className="mb-4 flex flex-wrap gap-4 text-sm">
          {isDrawMode ? (
            <>
              <div className="flex items-center gap-2">
                <div className="w-4 h-4 bg-black/10 bg-opacity-40 border-2 border-black border-dashed rounded"></div>
                <span>Drawing area</span>
              </div>
              <div className="flex items-center gap-2">
                <div className="w-4 h-4 bg-black/10 bg-opacity-40 border-2 border-black-10 rounded"></div>
                <span>Created seat</span>
              </div>
            </>
          ) : (
            <>
              <div className="flex items-center gap-2">
                <div className="w-4 h-4 bg-black/10 bg-opacity-50 border-2 border-black rounded"></div>
                <span>Hover</span>
              </div>
              <div className="flex items-center gap-2">
                <div className="w-4 h-4 bg-black/10 border-2 border-black rounded"></div>
                <span>Selected</span>
              </div>
            </>
          )}
        </div>

        {/* Image with seat overlay */}
        <div className="relative w-full bg-white rounded-lg shadow-lg overflow-hidden">
          <div
            ref={imageRef}
            className={`relative w-full ${
              isDrawMode ? 'cursor-crosshair' : 'cursor-pointer'
            }`}
            style={{ aspectRatio: '16/9' }}
            onMouseDown={handleMouseDown}
            onMouseMove={handleMouseMove}
            onMouseUp={handleMouseUp}
            onMouseLeave={handleMouseLeave}
          >
            <Image
              src="/images/test.webp"
              alt="Venue seating"
              fill
              className="object-contain pointer-events-none select-none"
              priority
            />

            {/* Existing seats */}
            {seats.map((seat) => {
              const isHovered = hoveredSeat === seat.id
              const isSelected = seat.selected

              return (
                <div
                  key={seat.id}
                  className={`absolute transition-all duration-200 rounded ${
                    isSelected
                      ? 'bg-black/10 border-2 border-black z-20 scale-105'
                      : isHovered
                      ? 'bg-black/10 bg-opacity-50 border-2 border-black z-10 scale-105'
                      : 'bg-black/10 bg-opacity-40 border-2 border-black'
                  } ${!isDrawMode ? 'cursor-pointer' : 'pointer-events-none'}`}
                  style={{
                    left: `${seat.x}%`,
                    top: `${seat.y}%`,
                    width: `${seat.width}%`,
                    height: `${seat.height}%`,
                  }}
                  onClick={() => !isDrawMode && handleSeatClick(seat.id)}
                >
                  {/* Seat label */}
                  <div className="absolute inset-0 flex items-center justify-center">
                    <span className="text-xs font-bold text-white drop-shadow-lg bg-black/40 bg-opacity-50 px-2 py-1 rounded">
                      {seat.name}
                    </span>
                  </div>
                  {/* Remove button - always visible in draw mode, visible on hover in select mode */}
                  {/* {(isDrawMode || isHovered) && (
                    <button
                      className="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full text-xs font-bold hover:bg-red-600 pointer-events-auto z-30 flex items-center justify-center shadow-lg"
                      onClick={(e) => {
                        e.stopPropagation()
                        removeSeat(seat.id)
                      }}
                      title="Remove seat"
                    >
                      ×
                    </button>
                  )} */}
                </div>
              )
            })}

            {/* Current drawing box */}
            {currentDrawingBox && (
              <div
                className="absolute bg-blue-500 bg-opacity-40 border-2 border-blue-600 border-dashed pointer-events-none rounded"
                style={{
                  left: `${currentDrawingBox.x}%`,
                  top: `${currentDrawingBox.y}%`,
                  width: `${currentDrawingBox.width}%`,
                  height: `${currentDrawingBox.height}%`,
                }}
              />
            )}
          </div>
        </div>

        {/* Seats list */}
        {seats.length > 0 && (
          <div className="mt-6">
            <h3 className="text-lg font-semibold text-gray-800 mb-3">
              Seats ({seats.length})
            </h3>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
              {seats.map((seat) => (
                <div
                  key={seat.id}
                  className={`bg-white p-3 rounded-lg shadow border-2 transition-all cursor-pointer ${
                    seat.selected
                      ? 'border-green-600 bg-green-50'
                      : 'border-gray-300 hover:border-blue-500'
                  }`}
                  onMouseEnter={() => setHoveredSeat(seat.id)}
                  onMouseLeave={() => setHoveredSeat(null)}
                  onClick={() => !isDrawMode && handleSeatClick(seat.id)}
                >
                  <div className="flex items-center justify-between">
                    <input
                      type="text"
                      value={seat.name}
                      onChange={(e) => renameSeat(seat.id, e.target.value)}
                      onClick={(e) => e.stopPropagation()}
                      className="text-sm font-semibold text-gray-700 bg-transparent border-b border-transparent hover:border-gray-300 focus:border-blue-500 focus:outline-none flex-1 mr-2"
                    />
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        removeSeat(seat.id)
                      }}
                      className="text-xs text-red-600 hover:text-red-800 font-semibold"
                    >
                      Delete
                    </button>
                  </div>
                  <div className="text-xs text-gray-500 mt-1">
                    Position: {seat.x.toFixed(1)}%, {seat.y.toFixed(1)}%
                  </div>
                  {seat.selected && (
                    <div className="text-xs text-green-600 font-semibold mt-1">
                      ✓ Selected
                    </div>
                  )}
                </div>
              ))}
            </div>
          </div>
        )}

        {/* Action button for selected seats */}
        {!isDrawMode && selectedSeats.length > 0 && (
          <div className="mt-6 flex gap-4">
            <button
              className="flex-1 md:flex-none px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors"
              onClick={() => {
                const seatNames = selectedSeats.map((s) => s.name).join(', ')
                alert(`Selected seats: ${seatNames}`)
              }}
            >
              Book {selectedSeats.length} Seat{selectedSeats.length !== 1 ? 's' : ''}
            </button>
          </div>
        )}

        {/* Instructions */}
        <div className="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
          <h4 className="font-semibold text-blue-900 mb-2">How to use:</h4>
          {isDrawMode ? (
            <ul className="text-sm text-blue-800 space-y-1">
              <li>• <strong>Draw Mode:</strong> Click and drag to draw rectangular areas over seats</li>
              <li>• Release to create a new clickable seat area</li>
              <li>• Click the × button to remove a seat</li>
              <li>• You can rename seats in the list below</li>
              <li>• Switch to Select Mode when done to test seat selection</li>
            </ul>
          ) : (
            <ul className="text-sm text-blue-800 space-y-1">
              <li>• <strong>Select Mode:</strong> Click on seats to select/deselect them</li>
              <li>• Hover over seats to highlight them</li>
              <li>• Selected seats are shown in green</li>
              <li>• Click &ldquo;Book&rdquo; button to confirm your selection</li>
              <li>• Switch to Draw Mode to add or modify seat areas</li>
            </ul>
          )}
        </div>
      </div>
    </div>
  )
}
