<script>

    export default {

        props: {
            'node': {
                default: null
            }
        },

        data() {
            return {
                open: true,
                mode: 'show',
                newNodeName: null,
            }
        },

        ready() {

            if (!this.node) // if there is no node than fetch first (root node)
            {
                this.$http.get('/cmsify/api/categories/hierarchy').then(function (response) {
                    for (var rootNode in response.data) {
                        this.node = response.data[rootNode];
                        break;
                    }
                });
            }
        },

        computed: {
            isFolder() {
                return this.node && this.node.children &&
                        this.node.children.length > 0
            },
            isOpen() {
                return this.open;
            }
        },

        methods: {
            clicknode() {

                if (this.isFolder) {
                    this.toggle();
                }

                this.$router.go({
                    name: 'pages',
                    params: {categoryId: this.node.id}
                });

            },
            toggle() {
                if (this.isFolder) {
                    this.open = !this.open
                }
            },
            isCreateMode() {
                return this.mode == 'create';
            },
            create() {
                this.mode = 'create';
            },
            store() {

                var parentNodeId = this.node ? this.node.id : null;

                if (!parentNodeId) {
                    alert("cant add a node!");
                    return;
                }

                var data = {
                    id: parentNodeId,
                    name: this.newNodeName
                };

                this.$http.post('/cmsify/api/categories', data).then(r => {
                    this.open = true;
                    if (!this.node.children) {
                        this.node.children = [];
                    }
                    this.node.children.push(r.data);
                    this.newNodeName = null;
                    this.mode = 'show';
                });

            },
            isEditMode() {
                return this.mode == 'edit';
            },
            edit() {
                this.mode = 'edit';
            },
            update() {
                this.$http.put('/cmsify/api/categories/' + this.node.id, {name: this.node.name}).then(r => {
                    this.node = r.data;
                    this.open = true;
                });
                this.mode = 'show';
            },
            remove() {
                this.$http.delete('/cmsify/api/categories/' + this.node.id).then(r => {
                    this.$dispatch('category-child-removed', {node : this.node});
                    this.node.children = null;
                    this.node = null;
                });
            }
        },

        events: {
            'category-child-removed': function(msg) {
                if(this.node.id == msg.node.parent_id) {
                    console.log(this.node)
                    this.node.children.$remove(msg.node);
                }
            }
        }
    }

</script>

<template>

    <ul>
        <li v-if="node">
            <a @click="clicknode" style="cursor: pointer">
                <form v-if="isEditMode()" @submit.prevent="update">
                    <input type="text" v-model="node.name"/>
                </form>
                <span v-else>{{node.name}}</span>
            </a>
            <i style="cursor: pointer"
               class="fa fa-edit"
               @click="edit"
            ></i>
            <i style="cursor: pointer"
               class="fa fa-plus"
               @click="create"
            ></i>
            <i v-if="!isFolder"
               style="cursor: pointer"
               class="fa fa-remove"
               @click="remove"
            ></i>
            <!--<button @click="removeChild">-</button>-->
            <!--<button @click="addChild">+</button>-->
            <!--<span v-if="isFolder" >[{{isOpen ? '-' : '+'}}]</span>-->

            <form v-if="isCreateMode()" @submit.prevent="store">
                <input type="text" v-model="newNodeName"/>
            </form>
            <span v-else>
                <cmsify-category v-if="isOpen && isFolder" v-for="node in node.children" :node="node"></cmsify-category>
             </span>
        </li>
    </ul>

</template>

<style>

    ul {
        font-size: 15px;
        list-style: none;
        padding: 3px;
        border-left: 1px solid #ccc;
        padding-left: 10px;
    }

</style>