import React from 'react'

type PageHeaderProps = {
    title: string
    description?: string
}

export default function PageHeader({ title, description }: PageHeaderProps) {
    return (
        <div className='flex flex-col items-start'>
            <h1 className='text-lg font-bold'>{title}</h1>

            {
                description && (
                    <p className='text-gray-500 text-sm'>{description}</p>
                )
            }
        </div>
    )
}
