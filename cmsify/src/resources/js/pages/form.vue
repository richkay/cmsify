<script>

    import modelFormMixin from '../mixins/ModelFormMixin';

    export default {

        mixins: [modelFormMixin],

        ready() {

            if(parseInt(this.$route.params.id)) {
                this.$http.get('/cmsify/api/posts/' + this.$route.params.id).then((r) => {
                    this.model = r.data;
                })
            }

        },

        methods: {

            getEndpoint() {
                if (parseInt(this.$route.params.categoryId)) {
                    return '/cmsify/api/categories/' + this.$route.params.categoryId + '/posts';
                }
                return '/cmsify/api/posts';
            },

        }

    }
</script>

<template>

    <form @submit.prevent="save()">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Title Form Input -->
                <div v-bind:class="{ 'has-error' : errors.title }" class="form-group">
                    <label for="title">Title</label>
                    <span v-if="errors.title" class="form-input-error">{{ errors.title }}</span>
                    <input type="text" name="title" class="form-control"
                           v-model="model.title"
                           placeholder="Title"
                           required
                    />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Text Form Input -->
                <div v-bind:class="{ 'has-error' : errors.text }" class="form-group">
                    <label for="text">Text</label>
                    <span v-if="errors.text" class="form-input-error">{{ errors.text }}</span>
                    <input type="text" name="text" class="form-control"
                           v-model="model.text"
                           placeholder="Text"
                           required
                    />
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" @click="setState('draft')" class="btn btn-primary">Draft</button>
                <button type="submit" @click="setState('published')" class="btn btn-success">Publish</button>
            </div>
        </div>

    </form>
</template>
