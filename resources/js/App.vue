<template>
    <div class="py-5 text-center">
        <h2>{{ appName }}</h2>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2 order-md-2 mb-4">
                <router-view></router-view>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; {{ appName }}</p>
    </footer>
</template>

<script>
export default {
    data: () => ({
        appName: 'Property App'
    })
}
</script>
