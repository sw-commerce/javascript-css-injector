import template from './sw-commerce-javascript-css-injector-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-commerce-javascript-css-injector-list', {
    template,

    inject: [
        'repositoryFactory',
        'context',
        'themeService',
    ],

    mixins: [
        Mixin.getByName('listing')
    ],

    data() {
        return {
            codeSnippets: null,
            isLoading: false,
            searchConfigEntity: 'sw_commerce_code_snippet',
            total: 0,
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },


    computed: {
        dateFilter() {
            return Shopware.Filter.getByName('date');
        },

        assetFilter() {
            return Shopware.Filter.getByName('asset');
        },

        salesChannelRepository() {
            return this.repositoryFactory.create('sales_channel');
        },

        codeSnippetRepository() {
            return this.repositoryFactory.create('sw_commerce_code_snippet');
        },

        columns() {
            return this.getColumns();
        },

        criteria() {
            const criteria = new Criteria(this.page, this.limit);

            if (this.term) {
                criteria.setTerm(this.term);
            }

            criteria.addAssociation('salesChannels');
            criteria.addSorting(Criteria.sort('createdAt', 'DESC', false));

            return criteria;
        },
    },

    methods: {

        updateRecords(results) {
            this.codeSnippets = results;
            this.total = results.total || 0;
        },

        getColumns() {
            return [
                {
                    property: 'name',
                    dataIndex: 'name',
                    label: this.$t('swcommerce-javascript-css-injector.columns.nameLabel'),
                    primary: true
                },
                {
                    property: 'active',
                    label: this.$t('swcommerce-javascript-css-injector.columns.activeLabel'),
                },
                {
                    property: 'salesChannels',
                    label: this.$t('swcommerce-javascript-css-injector.columns.salesChannelsLabel'),
                    sortable: false
                },
                {
                    property: 'renderPages',
                    label: this.$t('swcommerce-javascript-css-injector.columns.renderPages'),
                    sortable: false
                },
                {
                    property: 'createdAt',
                    label: this.$t('swcommerce-javascript-css-injector.columns.createdAtLabel'),
                }
            ];
        },

        async getList() {
            this.isLoading = true;

            const criteria = this.criteria;

            const newCriteria = await this.addQueryScores(this.term, criteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return;
            }

            if (this.freshSearchTerm) {
                newCriteria.resetSorting();
            }

            try {
                const codeSnippets = await this.codeSnippetRepository.search(newCriteria);
                this.total = codeSnippets.total || 0;
                this.codeSnippets = codeSnippets;
                this.selection = {};
            } catch {
                this.createNotificationError({
                    message: this.$tc('global.notification.unspecifiedSaveErrorMessage'),
                });
            } finally {
                this.isLoading = false;
            }

        },

        async handeClickDetail(item) {
            void this.$router.push({ name: 'sw.commerce.javascript.css.injector.detail', params: { id: item.id } });
        }
    },
});