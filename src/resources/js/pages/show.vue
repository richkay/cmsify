<script>

    import modelFormMixin from '../mixins/ModelFormMixin';
    import vSelect from 'vue-select';

    export default {

        components: {},

        data() {
            return {
                model: {}
            }
        },

        ready() {

            let vm = this;

            if (parseInt(vm.$route.params.id))
            {
                vm.$http.get('/cmsify/api/posts/' + vm.$route.params.id).then(r =>
                {
                    vm.model = r.data;
                });
            }
            else
            {

            }

        },

        methods: {}

    }
</script>

<template>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a v-link="{ name : 'pages', params: { categoryId : $route.params.categoryId } }" class="btn btn-default">Overview</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

            <h2>{{ model.title }}</h2>

            <p align="right">{{ model.updated_at }}</p>

            <p>{{{ model.text }}}</p>

            <hr/>

            <div v-if="model.tags && model.tags.length > 0">
                <strong>Tags</strong>:<br/>
                <span class="label label-default Relations__Item" v-for="tag in model.tags">{{ tag.name }}</span>
            </div>

            <div v-if="model.categories && model.categories.length > 0">
                <strong>Categories</strong>:<br/>
                <span class="label label-default Relations__Item" v-for="category in model.categories">{{ category.name }}</span>
            </div>

            <div v-for="relation in model.relations">

                <div v-if="model[relation.name] && model[relation.name].length > 0">
                    <strong>{{ relation.label }}</strong>:<br/>
                    <span class="label label-default Relations__Item" v-for="item in model[relation.name]">{{ item.name }}</span>
                </div>

            </div>

        </div>
    </div>

</template>

<style>

    .Relations__Item {
        margin-right:3px;
    }

</style>
