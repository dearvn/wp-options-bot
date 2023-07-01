/**
 * External dependencies.
 */
import { useSelect, useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
import OptionsCard from './OptionsCard';
import OptionsSubmit from './OptionsSubmit';
import jobStore from '../../data/options';
import OptionsFormSidebar from './OptionsFormSidebar';
import { IInputResponse, Input } from '../inputs/Input';
import { Select2SingleRow } from '../inputs/Select2Input';
import { IOptions, IOptionsFormData } from '../../interfaces';

type Props = {
    job?: IOptions;
};

export default function OptionsForm({ job }: Props) {
    const dispatch = useDispatch();
    const jobTypes: Array<Select2SingleRow> = useSelect(
        (select) => select(jobStore).getOptionsTypes(),
        []
    );

    const companyDropdowns: Array<Select2SingleRow> = useSelect(
        (select) => select(jobStore).getCompaniesDropdown(),
        []
    );

    const form: IOptionsFormData = useSelect(
        (select) => select(jobStore).getForm(),
        []
    );

    const loadingOptions: boolean = useSelect(
        (select) => select(jobStore).getLoadingOptions(),
        []
    );

    const onChange = (input: IInputResponse) => {
        dispatch(jobStore).setFormData({
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
                        <OptionsFormSidebar loading={loadingOptions} />
                    </div>

                    {loadingOptions ? (
                        <div className="md:basis-4/5">
                            <OptionsCard>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                            </OptionsCard>
                            <OptionsCard>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                                <div className="animate-pulse h-4 bg-slate-100 w-full p-2.5 rounded-lg mt-5"></div>
                            </OptionsCard>
                        </div>
                    ) : (
                        <>
                            <div className="md:basis-4/5">
                                <OptionsCard className="job-general-info">
                                    <Input
                                        type="text"
                                        label={__('Options title', 'optionsbot')}
                                        id="title"
                                        placeholder={__(
                                            'Enter Options title, eg: Software Engineer',
                                            'optionsbot'
                                        )}
                                        value={form.title}
                                        onChange={onChange}
                                    />
                                    <Input
                                        type="select"
                                        label={__('Options type', 'optionsbot')}
                                        id="options_type_id"
                                        value={form.options_type_id}
                                        options={jobTypes}
                                        onChange={onChange}
                                    />
                                </OptionsCard>
                                <OptionsCard className="job-description-info">
                                    <Input
                                        type="text-editor"
                                        label={__('Options details', 'optionsbot')}
                                        id="description"
                                        placeholder={__(
                                            'Enter Options description and necessary requirements.',
                                            'optionsbot'
                                        )}
                                        editorHeight="150px"
                                        value={form.description}
                                        onChange={onChange}
                                    />
                                </OptionsCard>
                                <OptionsCard className="job-company-info">
                                    <Input
                                        type="select"
                                        label={__('Company Name', 'optionsbot')}
                                        id="company_id"
                                        value={form.company_id}
                                        options={companyDropdowns}
                                        onChange={onChange}
                                    />
                                </OptionsCard>

                                <div className="flex justify-end md:hidden">
                                    <OptionsSubmit />
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </form>
        </div>
    );
}
