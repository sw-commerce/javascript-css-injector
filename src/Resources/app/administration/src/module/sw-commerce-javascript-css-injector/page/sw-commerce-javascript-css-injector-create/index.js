const { Component} = Shopware;

Component.extend('sw-commerce-javascript-css-injector-create', 'sw-commerce-javascript-css-injector-detail', {

    data() {
        return {
            canEdit: true,
            isNew: true,
        };
    },

    methods: {
        async getCodeSnippet() {
            this.codeSnippet = this.repository.create(Shopware.Context.api);
        },

        onClickSave() {
            this.isLoading = true;

            return this.repository
                .save(this.codeSnippet, Shopware.Context.api)
                .then(() => {
                    this.isLoading = false;
                    this.$router.push({
                        name: 'sw.commerce.javascript.css.injector.detail', params: { id: this.codeSnippet.id }
                    });

                    this.createNotificationSuccess({
                        message: this.$tc('swcommerce-javascript-css-injector.notification.saveSuccess'),
                    });
            }).catch(exception => {
                this.isLoading = false;

                this.createNotificationError({
                    title: this.$tc('swcommerce-javascript-css-injector.notification.saveError'),
                    message: exception
                })
            })
        },
    },

});