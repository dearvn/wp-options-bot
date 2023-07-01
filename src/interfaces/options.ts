/**
 * Internal dependencies.
 */
import { ISelect2Input } from '../components/inputs/Select2Input';

export interface IOptions {
    /**
     * Options ID.
     */
    id: number;

    /**
     * Options title.
     */
    title: string;

    /**
     * Options description.
     */
    description: string;

    /**
     * Options Type ID.
     */
    options_type_id: number;

    /**
     * Company ID.
     */
    company_id: number;

    /**
     * Status published or draft
     */
    is_active: boolean | number;

    /**
     * Options status.
     */
    status?: 'draft' | 'published' | 'trashed';
}

export interface IOptionsFormData extends IOptions {}

export interface IOptions {
    /**
     * All company list dropdown as array of {label, value}.
     */
    companyDropdowns: Array<ISelect2Input>;

    /**
     * All options as array of IOptions.
     */
    options: Array<IOptions>;

    /**
     * Options detail.
     */
    job: IOptions;

    /**
     * Options saving or not.
     */
    optionsSaving: boolean;

    /**
     * Options deleting or not.
     */
    optionsDeleting: boolean;

    /**
     * All job types as array of {label, value}.
     */
    jobTypes: Array<ISelect2Input>;

    /**
     * Is options loading.
     */
    loadingOptions: boolean;

    /**
     * Count total page.
     */
    totalPage: number;

    /**
     * Count total number of data.
     */
    total: number;

    /**
     * Options list filter.
     */
    filters: object;

    /**
     * Options Form data.
     */
    form: IOptionsFormData;
}

export interface IOptionsFilter {
    /**
     * Options filter by page no.
     */
    page?: number;

    /**
     * Options search URL params.
     */
    search?: string;
}
