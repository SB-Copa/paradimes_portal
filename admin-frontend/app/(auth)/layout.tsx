import Sidebar from '@/components/layout/Sidebar'
import Topbar from '@/components/layout/Topbar'
import React from 'react'

type MainAuthLayoutProps = {
    children: React.ReactNode
}

export default function MainAuthLayout({ children }: MainAuthLayoutProps) {
    return (
        <div className='flex'>
            <Sidebar />

            <div className="flex flex-col flex-1">
                <Topbar />

                <div className="flex flex-col p-8">
                    {children}
                </div>
            </div>
        </div>
    )
}
