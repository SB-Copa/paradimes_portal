import PageHeader from '@/components/layout/PageHeader';
import { dummyVenues } from '@/dummy/venues';
import Image from 'next/image';
import { notFound } from 'next/navigation';
import React from 'react'

type VenuePageProps = {
    params: {
        slug: string
    }
}

export default async function VenuePage({ params }: VenuePageProps) {
    const { slug } = await params;

    const venue = dummyVenues.find((venue) => venue.id === parseInt(slug))

    if (!venue) return notFound()

    return (
        <div className="flex flex-col gap-5">
            <PageHeader title={venue.name} description={venue.address} />

            <Image src={venue.banner_images[0]} alt={venue.name} width={1000} height={1000} />
        </div>
    )
}