/**
 * External dependencies.
 */
import { useSelect, useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
import OrderCard from './OrderCard';
import OrderSubmit from './OrderSubmit';
import orderStore from '../../data/order';
import OrderFormSidebar from './OrderFormSidebar';
import { IInputResponse, Input } from '../inputs/Input';
import { Select2SingleRow } from '../inputs/Select2Input';
import { IOrder, IOrderFormData } from '../../interfaces';

type Props = {
    order?: IOrder;
};

export default function OrderForm({ order }: Props) {
    const dispatch = useDispatch();
    
    const form: IOrderFormData = useSelect(
        (select) => select(orderStore).getForm(),
        []
    );

    const loadingOrder: boolean = useSelect(
        (select) => select(orderStore).getLoadingOrder(),
        []
    );

    const onChange = (input: IInputResponse) => {
        dispatch(orderStore).setFormData({
            ...form,
            [input.name]:
                typeof input.value === 'object'
                    ? input.value?.value
                    : input.value,
        });
    };

    return (
        <div className="mt-10">
            <form>
                <div className="flex flex-col md:flex-row">
                    <div className="md:basis-1/5">
                        <OrderFormSidebar loading={loadingOrder} />
                    </div>

                    {loadingOrder ? (
                        <div className="md:basis-4/5">
                            <OrderCard>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                            </OrderCard>
                            <OrderCard>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                            </OrderCard>
                        </div>
                    ) : (
                        <>
                            <div className="md:basis-4/5">
                                <OrderCard className="order-general-info">
                                    <Input
                                        type="text"
                                        label={__('Order title', 'optionsbot')}
                                        id="title"
                                        placeholder={__(
                                            'Enter Order title, eg: Software Engineer',
                                            'optionsbot'
                                        )}
                                        value={form.title}
                                        onChange={onChange}
                                    />
                                    <Input
                                        type="select"
                                        label={__('Order type', 'optionsbot')}
                                        id="options_type_id"
                                        value={form.options_type_id}
                                        options={orderTypes}
                                        onChange={onChange}
                                    />
                                </OrderCard>
                                <OrderCard className="order-description-info">
                                    <Input
                                        type="text-editor"
                                        label={__('Order details', 'optionsbot')}
                                        id="description"
                                        placeholder={__(
                                            'Enter Order description and necessary requirements.',
                                            'optionsbot'
                                        )}
                                        editorHeight="150px"
                                        value={form.description}
                                        onChange={onChange}
                                    />
                                </OrderCard>
                                <OrderCard className="order-company-info">
                                    <Input
                                        type="select"
                                        label={__('Company Name', 'optionsbot')}
                                        id="company_id"
                                        value={form.company_id}
                                        options={companyDropdowns}
                                        onChange={onChange}
                                    />
                                </OrderCard>

                                <div className="flex justify-end md:hidden">
                                    <OrderSubmit />
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </form>
        </div>
    );
}
