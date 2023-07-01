/**
 * Internal dependencies.
 */
import { IOptions } from '../../interfaces';

export const jobDefaultFormData = {
    id: 0,
    title: '',
    description: '',
    options_type_id: 0,
    company_id: 0,
    is_active: 1,
};

export const jobDefaultState: IOptions = {
    options: [],
    job: {
        ...jobDefaultFormData,
    },
    jobTypes: [],
    loadingOptions: false,
    optionsSaving: false,
    optionsDeleting: false,
    totalPage: 0,
    total: 0,
    filters: {},
    form: {
        ...jobDefaultFormData,
    },
    companyDropdowns: [],
};
