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

            let vm = this;

            vm.tags = [];
            vm.model.tags = [];
            vm.categories = [];
            vm.model.categories = [];

            if (parseInt(vm.$route.params.id)) {
                vm.$http.get('/cmsify/api/posts/' + vm.$route.params.id).then(r => {
                    vm.model = r.data;
                    vm.tags = r.data.tags;
                    vm.categories = r.data.categories;

                    vm.initTextEditor();

                });
            } else {

                // get custom relational data etc.
                vm.$http.get('/cmsify/api/posts/create').then(r => {
                    vm.model = r.data;

                    if (parseInt(vm.$route.params.categoryId)) {
                        vm.model.categories = [{
                            id: vm.$route.params.categoryId
                        }];
                    }

                });

                vm.initTextEditor();

            }

        },

        methods: {

            isCategoriesEnabled() {
                return ! window.categoriesDisabled;
            },

            initTextEditor() {
                var vm = this;
                if (typeof(initSummernote) == 'function') {
                    var editor = initSummernote();
                    editor.on('summernote.change', function (we, contents, $editable) {
                        vm.model.text = contents.toString();
                    });
                    editor.summernote('code', vm.model.text);
                }
            },

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

                <!-- Slug Form Input -->
                <div v-if="model.slug" v-bind:class="{ 'has-error' : errors.slug }" class="form-group">
                    <label for="slug">Slug</label>
                    <span v-if="errors.slug" class="form-input-error">{{ errors.slug }}</span>
                    <input type="text" name="slug" class="form-control"
                           v-model="model.slug"
                           placeholder="Slug"
                           required
                    />
                </div>


                <!-- Text Form Input -->
                <div v-bind:class="{ 'has-error' : errors.text }" class="form-group">
                    <label for="posts-text">Text</label>
                    <span v-if="errors.text" class="form-input-error">{{ errors.text }}</span>
                    <textarea name="posts-text"
                              class="form-control Summernote"
                              v-model="model.text"
                              placeholder="Text"
                              required
                    ></textarea>
                </div>

                <!-- Text Form Input -->
                <div v-bind:class="{ 'has-error' : errors.keywords }" class="form-group">
                    <label for="keywords">Keywords</label>
                    <span v-if="errors.keywords" class="form-input-error">{{ errors.keywords }}</span>
                    <input type="text" class="form-control"
                           v-model="model.keywords"
                           placeholder="optional"
                    />
                </div>

                <!-- Text Form Input -->
                <div v-bind:class="{ 'has-error' : errors.description }" class="form-group">
                    <label for="keywords">Description</label>
                    <span v-if="errors.description" class="form-input-error">{{ errors.description }}</span>
                    <textarea class="form-control"
                              v-model="model.description"
                              placeholder="optional"
                    ></textarea>
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

                <div v-if="model.id && isCategoriesEnabled()" class="form-group" v-bind:class="{ 'has-error' : errors.categories }">
                    <span v-if="errors.categories" class="form-input-error">{{ errors.categories }}</span>
                    <div>
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
                </div>

                <h3 v-if="model.relations">Relational Data</h3>

                <div class="form-group" v-for="relation in model.relations">
                    <label>{{ relation.label }}</label>
                    <v-select :multiple="relation.multiple"
                              :options="relation.options"
                              :value.sync="model[relation.name]"
                              label="name"></v-select>
                </div>

                <div v-bind:class="{ 'has-error' : errors.text }" class="form-group">
                    <button type="submit" @click="setState('draft')" class="btn btn-primary">Draft</button>
                    <button type="submit" @click="setState('published')" class="btn btn-success">Publish</button>
                </div>
            </div>
        </div>

    </form>
</template>

<style>

    .form-input-error {
        color: red;
    }

</style>