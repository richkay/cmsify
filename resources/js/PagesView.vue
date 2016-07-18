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
            <div class="col-xs-3">
                <a v-link="{ name: 'page_create' }">creage page</a>
                <a v-link="{ name: 'page_edit', params: {id : 1} }">edit page</a>
                TREE
            </div>

            <div class="col-xs-9">
                <router-view></router-view>
            </div>
        </div>

    </div>
</template>