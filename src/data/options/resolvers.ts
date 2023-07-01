/**
 * Internal dependencies.
 */
import actions from './actions';
import {
    companiesDropdownEndpoint,
    optionsEndpoint,
    jobTypesEndpoint,
} from './endpoint';
import {
    ICompanyDropdown,
    IOptionsFilter,
    IOptionsTypes,
    IResponseGenerator,
} from '../../interfaces';
import { formatSelect2Data } from '../../utils/Select2Helper';
import { prepareOptionsDataForDatabase } from './utils';

const resolvers = {
    *getOptions(filters: IOptionsFilter) {
        if (filters === undefined) {
            filters = {};
        }

        const queryParam = new URLSearchParams(
            filters as URLSearchParams
        ).toString();

        const response: IResponseGenerator = yield actions.fetchFromAPIUnparsed(
            `${optionsEndpoint}?${queryParam}`
        );
        let totalPage = 0;
        let totalCount = 0;

        if (response.headers !== undefined) {
            totalPage = response.headers.get('X-WP-TotalPages');
            totalCount = response.headers.get('X-WP-Total');
        }

        yield actions.setOptions(response.data);
        yield actions.setTotalPage(totalPage);
        yield actions.setTotal(totalCount);
        return actions.setLoadingOptions(false);
    },

    *getOptionsDetail(id: number) {
        yield actions.setLoadingOptions(true);
        const path = `${optionsEndpoint}/${id}`;
        const response = yield actions.fetchFromAPI(path);

        if (response.id) {
            const data = prepareOptionsDataForDatabase(response);

            yield actions.setFormData(data);
        }

        return actions.setLoadingOptions(false);
    },

    *getOptionsTypes() {
        const response: IResponseGenerator = yield actions.fetchFromAPIUnparsed(
            jobTypesEndpoint
        );

        const jobTypes: Array<IOptionsTypes> = response.data;

        yield actions.setOptionsTypes(formatSelect2Data(jobTypes));
    },

    *getCompaniesDropdown() {
        const response: IResponseGenerator = yield actions.fetchFromAPIUnparsed(
            companiesDropdownEndpoint
        );

        const companyDropdowns: Array<ICompanyDropdown> = response.data;

        yield actions.setCompanyDropdowns(formatSelect2Data(companyDropdowns));
    },
};

export default resolvers;
