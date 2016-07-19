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
                enableAddChildButton: true
            }
        },

        ready() {
            if (!this.node) {

                this.$http.get('/cmsify/api/categories').then(function (response) {
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
            toggle() {
                if (this.isFolder) {
                    this.open = !this.open
                }
            },
            addChild() {

                var vm = this;
                var nodeName = 'new Node';
                var nodeId = vm.node ? vm.node.id : null;

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
                        vm.node.children.push([]);
                        vm.open = true
                    }

                    vm.node.children.push({
                        id: response.id,
                        parent_id: response.parent_id,
                        name: response.name
                    });
                });
            },
            updateChild(node) {
                var vm = this;
                this.$http.put(
                        '/cmsify/api/categories' + vm.node.id,
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
                        '/cmsify/api/categories' + vm.node.id,
                        function (response) {
                            vm.node.children = null;
                            vm.node = null;
                        }
                );
            }
        }
    }

</script>

<template>

    <li v-if="node">
        <a v-if="isFolder" @click="toggle" style="cursor: pointer">
            {{node.name}}
        </a>
        <a v-else v-link="{ name: 'pages', params : {categoryId : node.id}}">
            {{node.name}}
        </a>
        <!--<button @click="removeChild">-</button>-->
        <!--<button @click="addChild">+</button>-->
        <!--<span v-if="isFolder" >[{{isOpen ? '-' : '+'}}]</span>-->
        <ul v-if="isFolder && open">
            <cmsify-category v-for="node in node.children" :node="node"></cmsify-category>
        </ul>
    </li>

</template>