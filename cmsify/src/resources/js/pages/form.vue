<script>

    import modelFormMixin from '../mixins/ModelFormMixin';
    import vSelect from 'vue-select';

    export default {

        mixins: [modelFormMixin],

        components: {
            vSelect
        },

        data() {
            return {
                tags: [],
                categories: [],
            }
        },

        ready() {

            this.tags = [];
            this.model.tags = [];
            this.categories = [];
            this.model.categories = [];

            if (parseInt(this.$route.params.id)) {
                this.$http.get('/cmsify/api/posts/' + this.$route.params.id).then(r => {
                    this.model = r.data;
                    this.tags = r.data.tags;
                    this.categories = r.data.categories;
                });
            } else {

                if (parseInt(this.$route.params.categoryId)) {
                    this.model.categories = [{
                        id: this.$route.params.categoryId
                    }];
                }

            }

        },

        methods: {

            getEndpoint() {
                return '/cmsify/api/posts';
            },

            afterSave(r)
            {
                this.model = r.data;
                this.tags = r.data.tags;
                this.categories = r.data.categories;
            },

            getTags(search, loading) {
                loading(true)
                this.$http.get('/cmsify/api/tags', {q: search}).then(r => {
                    this.tags = r.data;
                    loading(false)
                })
            },

            getCategories(search, loading) {
                loading(true)
                this.$http.get('/cmsify/api/categories', {q: search}).then(r => {
                    this.categories = r.data;
                    loading(false)
                })
            }

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

                <!-- Text Form Input -->
                <div v-bind:class="{ 'has-error' : errors.text }" class="form-group">
                    <label for="text">Text</label>
                    <span v-if="errors.text" class="form-input-error">{{ errors.text }}</span>
                    <textarea name="text" class="form-control"
                              v-model="model.text"
                              placeholder="Text"
                              required
                    /></textarea>
                </div>

                <div class="form-group">
                    <label>Tags</label>
                    <v-select multiple
                              :debounce="250"
                              :on-search="getTags"
                              :options.sync="tags"
                              :value.sync="model.tags"
                              placeholder="Tags..."
                              label="name"
                    >
                    </v-select>
                </div>

                <div class="form-group" v-if="model.id">
                    <label>Categories</label>
                    <v-select multiple
                              :debounce="250"
                              :on-search="getCategories"
                              :options.sync="categories"
                              :value.sync="model.categories"
                              placeholder="Categories..."
                              label="name"
                    >
                    </v-select>
                </div>

                <div v-bind:class="{ 'has-error' : errors.text }" class="form-group">
                    <button type="submit" @click="setState('draft')" class="btn btn-primary">Draft</button>
                    <button type="submit" @click="setState('published')" class="btn btn-success">Publish</button>
                </div>
            </div>
        </div>

    </form>
</template>
