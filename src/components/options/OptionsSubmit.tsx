/**
 * External dependencies.
 */
import { useNavigate } from 'react-router-dom';
import { useDispatch, useSelect } from '@wordpress/data';
import { faCheckCircle } from '@fortawesome/free-solid-svg-icons';
import Swal from 'sweetalert2';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
import jobStore from '../../data/options';
import Button from '../button/Button';
import { IOptionsFormData } from '../../interfaces';
import { jobDefaultFormData } from '../../data/options/default-state';

export default function OptionsSubmit() {
    const navigate = useNavigate();
    const dispatch = useDispatch();

    const form: IOptionsFormData = useSelect(
        (select) => select(jobStore).getForm(),
        []
    );

    const optionsSaving: boolean = useSelect(
        (select) => select(jobStore).getOptionsSaving(),
        []
    );

    const backToOptionsPage = () => {
        navigate('/options');
    };

    const validate = () => {
        if (!form.title.length) {
            return __('Please give a job title.', 'optionsbot');
        }

        if (form.options_type_id === 0) {
            return __('Please select job type.', 'optionsbot');
        }

        if (!form.description.length) {
            return __('Please give job description.', 'optionsbot');
        }

        if (form.company_id === 0) {
            return __('Please select a company.', 'optionsbot');
        }

        return '';
    };

    const onSubmit = () => {
        //Validate
        if (validate().length > 0) {
            Swal.fire({
                title: __('Error', 'optionsbot'),
                text: validate(),
                icon: 'error',
                toast: true,
                position: 'bottom',
                showConfirmButton: false,
                timer: 4000,
            });

            return;
        }

        // Submit
        dispatch(jobStore)
            .saveOptions(form)
            .then(() => {
                Swal.fire({
                    title: __('Options saved', 'optionsbot'),
                    text: __('Options has been saved successfully.', 'optionsbot'),
                    icon: 'success',
                    toast: true,
                    position: 'bottom',
                    showConfirmButton: false,
                    timer: 2000,
                });
                dispatch(jobStore).setFormData({
                    ...jobDefaultFormData,
                });
                navigate('/options');
            })
            .catch((error) => {
                Swal.fire({
                    title: __('Error', 'optionsbot'),
                    text: error.message,
                    icon: 'error',
                    toast: true,
                    position: 'bottom',
                    showConfirmButton: false,
                    timer: 3000,
                });
            });
    };

    return (
        <>
            <Button
                text={__('Cancel', 'optionsbot')}
                type="default"
                onClick={backToOptionsPage}
                buttonCustomClass="mr-3"
            />

            <Button
                text={
                    optionsSaving
                        ? __('Saving…', 'optionsbot')
                        : __('Save', 'optionsbot')
                }
                type="primary"
                icon={faCheckCircle}
                disabled={optionsSaving}
                onClick={onSubmit}
            />
        </>
    );
}
