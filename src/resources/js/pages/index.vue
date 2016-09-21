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

            setTimeout(function ()
            {
                $('[data-toggle="tooltip"]').tooltip()
            }, 1000);

        },

        methods: {

            load(categoryId) {
                if (parseInt(categoryId))
                {
                    this.$http.get('/cmsify/api/categories/' + categoryId + '/posts').then(r =>
                    {
                        this.posts = r.data;
                    });
                }
                else
                {
                    this.$http.get('/cmsify/api/posts').then(r =>
                    {
                        this.posts = r.data;
                    });
                }
            },

            destroy(post) {

                this.$http.delete('/cmsify/api/posts/' + post.id).then(r =>
                {
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
                            <td>{{ post.id }}
                                <label class="label label-success" v-if="post.state == 'published'">published</label>
                                <label class="label label-primary" v-else>draft</label>
                            </td>
                            <td>
                                {{ post.title }}
                            </td>
                            <td>{{ post.created_at | moment 'YYYY-DD-MM h:mm' }}</td>
                            <td>{{ post.updated_at | moment 'YYYY-DD-MM h:mm' }}</td>
                            <td class="text-right">

                                <a class="btn btn-default"
                                   v-link="{name : 'page_show', params : {categoryId : $route.params.categoryId, id: post.id }}"
                                ><i class="fa fa-list"></i></a>

                                <!--Edit button-->
                                <a v-if="post.canEdit"
                                   v-link="{name : 'page_edit', params : {categoryId : $route.params.categoryId, id: post.id }}"
                                   class="btn btn-primary"
                                ><i class="fa fa-edit"></i></a>
                                <button v-else
                                        style="opacity: 0.5"
                                        class="btn btn-primary"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="only Creator has Permission"
                                ><i class="fa fa-edit"></i></button>

                                <!--Remove Button-->
                                <button v-if="post.canDelete" @click="destroy(post)" class="btn btn-danger"><i
                                        class="fa fa-remove"></i></button>
                                <button v-else
                                        style="opacity: 0.5"
                                        class="btn btn-danger"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="only Creator has Permission"
                                ><i class="fa fa-remove"></i>
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