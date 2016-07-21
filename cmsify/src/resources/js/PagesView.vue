<script>

    export default {}

</script>

<template>

    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1>CMSify</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4 col-md-2">
                <div style="border-left:1px solid #ccc;">
                    <cmsify-category></cmsify-category>
                </div>
            </div>

            <div class="col-xs-8 col-md-10">
                <router-view></router-view>
            </div>
        </div>

        <hr>
        <pre>{{ $route.params | json }}</pre>

    </div>
</template>