# TODO: Separate Operator Verification from Dashboard

## Steps to Complete

-   [x] Create `resources/js/Pages/operator/Opverify.vue` with extracted verification modal logic and redirection to `/operator` on success
-   [x] Modify `resources/js/Pages/operator/Operator.vue` to remove verification code (modal, state, logic) and display dashboard directly
-   [x] Update `routes/web.php` to add new route for `/opverify` rendering `Opverify.vue`
-   [x] Test the new `/opverify` route and verify redirection to `/operator` after verification
-   [x] Verify that `Operator.vue` loads dashboard without verification
