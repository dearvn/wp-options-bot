/**
 * Internal dependencies.
 */
import { Select2SingleRow } from '../../components/inputs/Select2Input';
import { IOptions, IOptionsFormData, IResponseGenerator } from '../../interfaces';
import { optionsEndpoint } from './endpoint';
import * as Types from './types';
import { jobDefaultFormData } from './default-state';

const actions = {
    setOptions(options: Array<IOptions>) {
        return {
            type: Types.GET_OPTIONS,
            options,
        };
    },

    setOptionsDetail(job: IOptions) {
        return {
            type: Types.GET_OPTIONS_DETAIL,
            job,
        };
    },

    setFormData(form: IOptionsFormData) {
        return {
            type: Types.SET_OPTIONS_FORM_DATA,
            form,
        };
    },

    setLoadingOptions(loadingOptions: boolean) {
        return {
            type: Types.SET_LOADING_OPTIONS,
            loadingOptions,
        };
    },

    setSavingOptions(optionsSaving: boolean) {
        return {
            type: Types.SET_OPTIONS_SAVING,
            optionsSaving,
        };
    },

    setDeletingOptions(optionsDeleting: boolean) {
        return {
            type: Types.SET_OPTIONS_DELETING,
            optionsDeleting,
        };
    },

    *setFilters(filters = {}) {
        yield actions.setLoadingOptions(true);
        yield actions.setFilterObject(filters);

        const queryParam = new URLSearchParams(
            filters as URLSearchParams
        ).toString();

        const path = `${optionsEndpoint}?${queryParam}`;
        const response: {
            headers: Headers;
            data;
        } = yield actions.fetchFromAPIUnparsed(path);

        let totalPage = 0;
        let totalCount = 0;

        if (response.headers !== undefined) {
            totalPage = parseInt(response.headers.get('X-WP-TotalPages'));
            totalCount = parseInt(response.headers.get('X-WP-Total'));
        }

        yield actions.setTotalPage(totalPage);
        yield actions.setTotal(totalCount);
        yield actions.setOptions(response.data);
        return actions.setLoadingOptions(false);
    },

    setFilterObject(filters: object) {
        return {
            type: Types.SET_OPTIONS_FILTER,
            filters,
        };
    },

    *saveOptions(payload: IOptionsFormData) {
        yield actions.setSavingOptions(true);

        try {
            let response: IResponseGenerator = {};
            if (payload.id > 0) {
                response = yield {
                    type: Types.UPDATE_OPTIONS,
                    payload,
                };
            } else {
                response = yield {
                    type: Types.CREATE_OPTIONS,
                    payload,
                };
            }

            if (response?.id > 0) {
                yield actions.setFormData({ ...jobDefaultFormData });
                yield actions.setSavingOptions(false);
            }
        } catch (error) {
            yield actions.setSavingOptions(false);
        }
    },

    setTotalPage(totalPage: number) {
        return {
            type: Types.SET_TOTAL_OPTIONS_PAGE,
            totalPage,
        };
    },

    setTotal(total: number) {
        return {
            type: Types.SET_TOTAL_OPTIONS,
            total,
        };
    },

    fetchFromAPI(path: string) {
        return {
            type: Types.FETCH_FROM_API,
            path,
        };
    },

    fetchFromAPIUnparsed(path: string) {
        return {
            type: Types.FETCH_FROM_API_UNPARSED,
            path,
        };
    },

    *deleteOptions(payload: Array<number>) {
        yield actions.setDeletingOptions(true);

        try {
            const responseDeleteOptions: IResponseGenerator = yield {
                type: Types.DELETE_OPTIONS,
                payload,
            };

            if (responseDeleteOptions?.total > 0) {
                yield actions.setFilters({});
            }

            yield actions.setDeletingOptions(false);
        } catch (error) {
            yield actions.setDeletingOptions(false);
        }
    },
};

export default actions;
