import Link from 'next/link'
import React from 'react'

export default function Sidebar() {
  return (
    <div className="flex flex-col p-4 border-r border-gray-200 shadow h-screen gap-6">
      <h1>Admin Portal</h1>


      <div className="flex flex-col gap-2">
        <Link href='/dashboard'>Dashboard</Link>
        <Link href='/venues'>Venues</Link>
      </div>
    </div>
  )
}
