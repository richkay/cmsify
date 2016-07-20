export default {

    data() {
        return {
            model: {},
            errors: {}
        }
    },

    methods: {

        save() {

            var endpoint = this.getEndpoint();

            if(this.model.id) {
                var method = 'put';
                endpoint += '/' + this.model.id;
            } else {
                var method = 'post';
            }

            this.$http[method](endpoint, this.model).then((r) => {
                this.model = r.data;
            }).catch((r) => {
                this.errors = r.data;
            });

        }

    }

}