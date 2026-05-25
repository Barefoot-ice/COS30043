<script setup="js">
import JobApproveView from './jobApproveView.vue';

</script>

<template>
    <div class="container">
        <Suspense>
            <div class="w-100 d-flex">
                <JobApproveView />
                <div class="detail-view">
                    <router-view />

                </div>
            </div>

            <template #fallback>
                Loading...
            </template>
        </Suspense>
    </div>

</template>