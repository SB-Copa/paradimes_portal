import PageHeader from '@/components/layout/PageHeader'
import { dummyVenues } from '@/dummy/venues'
import { Card, CardActionArea, CardContent, CardMedia } from '@mui/material'
import Link from 'next/link'
import React from 'react'

export default function VenuesPage() {
    return (
        <div className="flex flex-col gap-10">
            <PageHeader title='Venues' description='Manage your event venues' />

            <div className="grid grid-cols-4 gap-5">

                {
                    dummyVenues.map((venue) => (
                        <Card key={venue.id}>
                            <CardActionArea>
                                <Link href={`/venues/${venue.id}`}>
                                    <CardMedia
                                        component="img"
                                        height="100%"
                                        image={venue.banner_images[0]}
                                        alt={venue.name}
                                    />
                                    <CardContent>
                                        <h3 className='text-lg font-bold'>{venue.name}</h3>
                                        <p className='text-sm text-gray-500'>{venue.address}</p>
                                        {/* <p className='text-sm text-gray-500'>{venue.capacity}</p> */}
                                    </CardContent>
                                </Link>
                            </CardActionArea>

                        </Card>
                    ))
                }
            </div>
        </div>
    )
}
