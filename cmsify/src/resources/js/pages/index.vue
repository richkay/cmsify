<script>

    export default {

        data() {
            return {
                posts: []
            }
        },

        ready() {

            this.$http.get('/cmsify/api/categories/' + this.$route.params.categoryId + '/posts').then(function (response) {
                this.posts = response.data;
            }).catch(function (response) {
                console.log(response);
            })
        }

    }
</script>

<template>

    <div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                            <td>
                                <a v-link="{name : 'page_edit', params : {categoryId : $route.params.categoryId, id: post.id }}"
                                   class="btn btn-primary"
                                >Edit</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>

</template>