<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppNavbar from '@/Components/AppNavbar.vue';
import AppFooter from '@/Components/AppFooter.vue'; 

// --- Data Halaman (Ganti dengan Props Inertia dari Backend Anda) ---
const teamMembers = [
    { id: 1, name: 'John Kalabras', title: 'CEO', image: '/images/profile.jpg' },
    { id: 2, name: 'Philips shane murli', title: 'COO', image: '/images/profile.jpg' },
    { id: 3, name: 'Equanim shamir mohamad', title: 'Tech Head', image: '/images/profile.jpg' },
    { id: 4, name: 'Jenka Imdkragith', title: 'Head of UX', image: '/images/profile.jpg' },
];

const services = [
    { title: 'Web Application', iconClass: 'bg-red-100 text-red-500' },
    { title: 'SEO', iconClass: 'bg-green-100 text-green-500' },
    { title: 'Mobile Applications', iconClass: 'bg-purple-100 text-purple-500' },
    { title: 'AR/VR', iconClass: 'bg-pink-100 text-pink-500' },
];

const imageUrls = {
    img1: '/images/kerja.png',
    img2: '/images/rapat.png', 
    img3: '/images/diskusi.png',
    img4: '/images/2pria.png', 
};
</script>

<template>
    <Head title="About Us" />

    <AppNavbar />
    
    <main class="text-gray-800">

        <section class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                
                <div class="space-y-4 order-2 lg:order-1">
                    <div class="grid grid-cols-2 gap-x-0">
                        <img :src="imageUrls.img1" alt="Tim bekerja di kantor" class="w-full h-48 object-cover rounded-xl shadow-lg">
                        <img :src="imageUrls.img2" alt="Rapat tim" class="w-48 h-full object-cover rounded-xl shadow-lg mb-8 ms-8">
                    </div>
                    <img :src="imageUrls.img3" alt="Diskusi serius" class="w-full h-48 object-cover rounded-xl shadow-lg">
                </div>

                <div class="lg:pt-16 order-1 lg:order-2">
                    <p class="text-green-500 font-semibold  uppercase mb-2">About us</p>
                    <h3 class="text-3xl sm:text-5xl font-semibold leading-tight text-gray-900 mb-6">
                        Lorem ipsum is simply dummy text of the printing.
                    </h3>
                    <p class="text-lg text-gray-600 mb-6">
                        Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                    </p>
                    <img :src="imageUrls.img4" alt="Dua pria bekerja di laptop" class="w-full h-64 object-cover rounded-xl shadow-lg mt-6 hidden lg:block"> 
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl sm:text-4xl font-semibold leading-snug text-gray-900 mb-6">
                    Lorem ipsum is simply dummy text of the printing.
                </h2>
                <p class="text-gray-600 text-lg">
                    <span class="font-bold text-green-500">KODE TECHNOLOGY (PVT) LTD</span> is a team of experienced mobile and web applications and website builders measuring dozens of clients from all over the world. We offer a full range of services for all popular platforms, including Android & iOS. We build and develop mobile applications for several top platforms, including Android & iOS.
                </p>
            </div>
        </section>
        
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                
                <div class="pr-0 lg:pr-10 order-2 lg:order-1">
                    <div class="border-l-4 border-green-500 pl-4 mb-4">
                        <h2 class="text-3xl sm:text-4xl font-semibold leading-snug text-gray-900">
                            Lorem ipsum is simply dummy text of the printing.
                        </h2>
                    </div>
                    <p class="text-gray-600 text-lg mb-6">
                        KODE TECHNOLOGY (PVT) LTD is a team of experienced mobile and web applications and website builders measuring dozens of clients from all over the world. We offer a full range of services for all popular platforms and completed projects.
                    </p>
                    <Link href="/contact" class="inline-block px-8 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-300">
                        Contact Us
                    </Link>
                </div>

                <div class="grid grid-cols-2 gap-4 p-6 bg-white rounded-xl shadow-xl border border-gray-100 order-1 lg:order-2">
                    <div v-for="service in services" :key="service.title" class="flex flex-col items-start p-4 bg-gray-50 rounded-lg transition duration-300">
                        <div class="p-3 mb-2 rounded-full" :class="service.iconClass">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ service.title }}</h3>
                    </div>
                </div>

            </div>
        </section>
        
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Our Team</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                
                <div v-for="member in teamMembers" :key="member.id" class="text-left">
                    <img :src="member.image" :alt="member.name" class="w-full h-72 object-cover rounded-lg mb-3 shadow-lg">
                    <p class="text-sm text-gray-500 uppercase">{{ member.title }}</p>
                    <p class="text-xl font-semibold text-gray-900">{{ member.name }}</p>
                </div>

            </div>
            <div class="flex justify-center mt-8 space-x-2">
                <span class="block w-2 h-2 bg-gray-300 rounded-full"></span>
                <span class="block w-2 h-2 bg-green-500 rounded-full"></span>
                <span class="block w-2 h-2 bg-gray-300 rounded-full"></span>
                <span class="block w-2 h-2 bg-gray-300 rounded-full"></span>
            </div>
        </section>

    </main>
    
    <AppFooter />
</template>