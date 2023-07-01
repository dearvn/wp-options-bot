/**
 * Internal dependencies.
 */
import * as Types from './types';
import { jobDefaultState } from './default-state';

const reducer = (state = jobDefaultState, action: any) => {
    switch (action.type) {
        case Types.GET_OPTIONS:
            return {
                ...state,
                options: action.options,
            };

        case Types.GET_OPTIONS_DETAIL:
            return {
                ...state,
                job: action.job,
            };

        case Types.GET_OPTIONS_TYPES:
            return {
                ...state,
                jobTypes: action.jobTypes,
            };

        case Types.GET_COMPANIES_DROPDOWN:
            return {
                ...state,
                companyDropdowns: action.companyDropdowns,
            };

        case Types.SET_LOADING_OPTIONS:
            return {
                ...state,
                loadingOptions: action.loadingOptions,
            };

        case Types.SET_TOTAL_OPTIONS:
            return {
                ...state,
                total: action.total,
            };

        case Types.SET_TOTAL_OPTIONS_PAGE:
            return {
                ...state,
                totalPage: action.totalPage,
            };

        case Types.SET_OPTIONS_FILTER:
            return {
                ...state,
                filters: action.filters,
            };

        case Types.SET_OPTIONS_FORM_DATA:
            return {
                ...state,
                form: action.form,
            };

        case Types.SET_OPTIONS_SAVING:
            return {
                ...state,
                optionsSaving: action.optionsSaving,
            };
    }

    return state;
};

export default reducer;
