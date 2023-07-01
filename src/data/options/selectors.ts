/**
 * Internal dependencies.
 */

import { IOptions } from '../../interfaces';

const selectors = {
    getOptions(state: IOptions) {
        const { options } = state;

        return options;
    },

    getOptionsDetail(state: IOptions) {
        const { job } = state;

        return job;
    },

    getOptionsTypes(state: IOptions) {
        const { jobTypes } = state;

        return jobTypes;
    },

    getOptionsSaving(state: IOptions) {
        const { optionsSaving } = state;

        return optionsSaving;
    },

    getOptionsDeleting(state: IOptions) {
        const { optionsDeleting } = state;

        return optionsDeleting;
    },

    getLoadingOptions(state: IOptions) {
        const { loadingOptions } = state;

        return loadingOptions;
    },

    getTotalPage(state: IOptions) {
        const { totalPage } = state;

        return totalPage;
    },

    getTotal(state: IOptions) {
        const { total } = state;

        return total;
    },

    getFilter(state: IOptions) {
        const { filters } = state;

        return filters;
    },

    getForm(state: IOptions) {
        const { form } = state;

        return form;
    },

    getCompaniesDropdown(state: IOptions) {
        const { companyDropdowns } = state;

        return companyDropdowns;
    },
};

export default selectors;
