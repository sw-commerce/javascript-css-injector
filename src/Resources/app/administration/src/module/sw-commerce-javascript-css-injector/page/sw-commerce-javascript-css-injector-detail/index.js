import template from './sw-commerce-javascript-css-injector-detail.html.twig';

const { Component, Mixin, Filter } = Shopware;
const { mapPropertyErrors } = Shopware.Component.getComponentHelper();
const { Criteria } = Shopware.Data;

Component.register('sw-commerce-javascript-css-injector-detail', {
    template,

    inject: [
        'repositoryFactory',
        'context',
        'acl',
        'themeService',
    ],


    mixins: [
        Mixin.getByName('notification')
    ],

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    data() {
        return {
            codeSnippet: null,
            isLoading: false,
            trackingCodes: []
        };
    },

    computed: {
        ...mapPropertyErrors('codeSnippet', ['name']),

        salesChannelRepository() {
            return this.repositoryFactory.create('sales_channel');
        },

        repository() {
            return this.repositoryFactory.create('sw_commerce_code_snippet');
        }
    },

    created() {
        this.createdComponent()
    },

    methods: {
        async createdComponent() {
            this.getCodeSnippet();
        },

        async getCodeSnippet() {
            try {
                this.codeSnippet = await this.repository.get(this.$route.params.id, Shopware.Context.api);
            } catch (error) {
                this.createNotificationError({
                    title: this.$tc('swcommerce-javascript-css-injector.notification.saveError'),
                    message: error
                })
            }
        },

        onClickSave() {
            this.isLoading = true;

            return this.repository
                .save(this.codeSnippet, Shopware.Context.api)
                .then(() => {
                    this.getCodeSnippet();

                    this.createNotificationSuccess({
                        message: this.$tc('swcommerce-javascript-css-injector.notification.saveSuccess'),
                    });

                    this.isLoading = false;
                }).catch((exception) => {
                    this.isLoading = false;
                    if (this.codeSnippet.name && this.codeSnippet.name.length) {
                        this.createNotificationError({
                            title: this.$tc('swcommerce-javascript-css-injector.notification.saveError'),
                            message: exception
                        });
                    }
                });
        },
    },
});