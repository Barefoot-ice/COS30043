<script>
</script>

<template>
    <div class="container flex-column">
        <div class="row m-2">
            <div class="col">
                <h1 class="text-danger">You are not authorised to view this content</h1>
            </div>
        </div>
        <div class="row m-2">
            <div class="col">
                <router-link to="/home" custom v-slot="{ navigate }">
                    <button type="button" class="btn btn-warning" @click="navigate">
                        Go Home
                    </button>
                </router-link>
            </div>
        </div>
    </div>
</template>