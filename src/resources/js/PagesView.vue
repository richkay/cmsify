<script>

    export default {

        methods: {
            isCategoriesEnabled() {
                return !window.categoriesDisabled;
            }
        }

    }

</script>

<template>

    <div class="container">

        <div class="row" v-if="isCategoriesEnabled()">
            <div class="col-xs-4 col-md-3">
                <div>
                    <cmsify-category></cmsify-category>
                </div>
            </div>

            <div class="col-xs-8 col-md-9">
                <router-view></router-view>
            </div>
        </div>

        <div class="row" v-else="isCategoriesEnabled()">
            <div class="col-xs-8 col-md-12">
                <router-view></router-view>
            </div>
        </div>

        <!--<hr>-->
        <!--<pre>{{ $route.params | json }}</pre>-->

    </div>
</template>