/**
 * Internal dependencies.
 */
import { IOptions } from '../../interfaces';

export const prepareOptionsDataForDatabase = (job: IOptions) => {
    const data = {
        ...job,
        options_type_id: job.options_type.id,
        company_id: job.company.id,
    };

    if (job.is_active !== undefined) {
        data.is_active = job.is_active;
    } else {
        data.is_active = 1;
    }

    // Remove unnecessary data.
    delete data.company;
    delete data.options_type;
    delete data.status;
    delete data._links;

    return data;
};
