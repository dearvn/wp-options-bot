/**
 * Internal dependencies.
 */
import * as Types from './types';
import { jobDefaultState } from './default-state';

const reducer = (state = jobDefaultState, action: any) => {
    switch (action.type) {
        case Types.GET_ORDER:
            return {
                ...state,
                order: action.order,
            };

        case Types.GET_ORDER_DETAIL:
            return {
                ...state,
                job: action.job,
            };

        case Types.SET_LOADING_ORDER:
            return {
                ...state,
                loadingOptions: action.loadingOptions,
            };

        case Types.SET_TOTAL_ORDER:
            return {
                ...state,
                total: action.total,
            };

        case Types.SET_TOTAL_ORDER_PAGE:
            return {
                ...state,
                totalPage: action.totalPage,
            };

        case Types.SET_ORDER_FILTER:
            return {
                ...state,
                filters: action.filters,
            };

        case Types.SET_ORDER_FORM_DATA:
            return {
                ...state,
                form: action.form,
            };

        case Types.SET_ORDER_SAVING:
            return {
                ...state,
                orderSaving: action.orderSaving,
            };
    }

    return state;
};

export default reducer;
