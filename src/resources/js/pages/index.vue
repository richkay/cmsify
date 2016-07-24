<script>

    export default {

        route: {
            data() {
                this.load(this.$route.params.categoryId);
            }
        },

        data() {
            return {
                posts: []
            }
        },

        ready() {

        },

        methods: {

            load(categoryId) {
                this.$http.get('/cmsify/api/categories/' + categoryId + '/posts').then(r => {
                    this.posts = r.data;
                });
            },

            destroy(post) {

                this.$http.delete('/cmsify/api/posts/' + post.id).then(r => {
                    this.posts.$remove(post);
                });

            }

        }

    }
</script>

<template>

    <div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <a v-link="{name : 'page_create', params : {categoryId : $route.params.categoryId }}"
                   class="btn btn-primary"
                >Create Post</a>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="post in posts">
                            <td>{{ post.id }}</td>
                            <td>{{ post.title }}</td>
                            <td>{{ post.created_at | moment 'YYYY-DD-MM h:mm' }}</td>
                            <td>{{ post.updated_at | moment 'YYYY-DD-MM h:mm' }}</td>
                            <td class="text-right">
                                <a v-link="{name : 'page_edit', params : {categoryId : $route.params.categoryId, id: post.id }}"
                                   class="btn btn-primary"
                                ><i class="fa fa-edit"></i> </a>
                                <button @click="destroy(post)" class="btn btn-danger"><i class="fa fa-remove"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</template>