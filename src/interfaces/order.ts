/**
 * Internal dependencies.
 */
import { ISelect2Input } from '../components/inputs/Select2Input';

export interface IOrder {
    /**
     * Order ID.
     */
    id: number;

    /**
     * Order title.
     */
    title: string;

    /**
     * Order description.
     */
    description: string;

    /**
     * Order Type ID.
     */
    orders_type_id: number;

    /**
     * Company ID.
     */
    company_id: number;

    /**
     * Status published or draft
     */
    is_active: boolean | number;

    /**
     * Order status.
     */
    status?: 'open' | 'closed' | 'cancelled';
}

export interface IOrderFormData extends IOrder {}

export interface IOrder {
    /**
     * All orders as array of IOrder.
     */
    orders: Array<IOrder>;

    /**
     * Order detail.
     */
    order: IOrder;

    /**
     * Order saving or not.
     */
    ordersSaving: boolean;

    /**
     * Order deleting or not.
     */
    ordersDeleting: boolean;

    /**
     * All job types as array of {label, value}.
     */
    jobTypes: Array<ISelect2Input>;

    /**
     * Is orders loading.
     */
    loadingOrder: boolean;

    /**
     * Count total page.
     */
    totalPage: number;

    /**
     * Count total number of data.
     */
    total: number;

    /**
     * Order list filter.
     */
    filters: object;

    /**
     * Order Form data.
     */
    form: IOrderFormData;
}

export interface IOrderFilter {
    /**
     * Order filter by page no.
     */
    page?: number;

    /**
     * Order search URL params.
     */
    symbol?: string;
}

