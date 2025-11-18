# TODO: Update Admin Navbar for Mobile View

## Tasks

-   [x] Edit NavbarAdmin.vue to remove mobile menu button and dropdown
-   [x] Ensure mobile view shows only logo and profile icon like user dashboard
-   [x] Test mobile responsiveness

## Information Gathered

-   NavbarAdmin.vue is used in AdminDashboard.vue and AdminProfile.vue
-   Currently has mobile menu button with hamburger icon
-   NavbarUser.vue has no mobile menu, only logo and profile icon
-   Task: Make admin navbar on mobile same as user dashboard, no lines or dots, direct logo profile

## Plan

-   Remove mobile menu button and related dropdown from NavbarAdmin.vue
-   Keep desktop profile icon, mobile only logo and profile icon

## Dependent Files

-   resources/js/Components/NavbarAdmin.vue

## Followup Steps

-   Verify mobile view displays correctly
-   Check if any other files reference mobile menu
