<script>

    export default {

        props: {
            'tree': {
                default: null
            }
        },

        data() {
            return {
                open: true,
                enableAddChildButton: true
            }
        },

        ready() {
            console.log("huhu");
            if (!this.tree) {

                this.$http.get('/cmsify/api/categories').then(function (response) {
                    for (var rootNode in response.data) {
                        this.tree = response.data[rootNode];
                        console.log(this.tree);
                        break;
                    }
                });
            }
        },

        computed: {
            isFolder() {
                return this.tree && this.tree.children &&
                        this.tree.children.length > 0
            },
            isOpen() {
                return this.open;
            }
        },

        methods: {
            toggle() {
                if (this.isFolder) {
                    this.open = !this.open
                }
            },
            addChild() {

                var vm = this;
                var nodeName = 'new Node';
                var nodeId = vm.tree ? vm.tree.id : null;

                if (!nodeId) {
                    alert("cant add a node!");
                    return;
                }

                var data = {
                    id: nodeId,
                    name: nodeName
                };

                vm.$http.post('/cmsify/api/categories', data).then(function (response) {
                    this.enableAddChildButton = true;
                    this.open = true;

                    if (!vm.isFolder) {
                        vm.tree.children.push([]);
                        vm.open = true
                    }

                    vm.tree.children.push({
                        id: response.id,
                        parent_id: response.parent_id,
                        name: response.name
                    });
                });
            },
            updateChild(node) {
                var vm = this;
                this.$http.put(
                        '/cmsify/api/categories' + vm.tree.id,
                        {
                            name: node.nodeName
                        },
                        function (response) {
                            this.open = true;
                        }
                );
            },
            removeChild() {
                var vm = this;
                this.$http.delete(
                        '/cmsify/api/categories' + vm.tree.id,
                        function (response) {
                            vm.tree.children = null;
                            vm.tree = null;
                        }
                );
            }
        }
    }

</script>

<template>

    <li v-if="tree">
        <span @click="toggle">
            <cmsify-category-node :name="tree.name"></cmsify-category-node>
        </span>
        <button @click="removeChild">-</button>
        <button @click="addChild">+</button>
        <span v-if="isFolder" @click="toggle">[{{isOpen ? '-' : '+'}}]</span>
        <ul v-show="open" v-if="isFolder">
            <cmsify-category v-for="tree in tree.children" :tree="tree"></cmsify-category>
        </ul>
    </li>

</template>