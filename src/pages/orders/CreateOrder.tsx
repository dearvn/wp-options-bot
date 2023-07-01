/**
 * External dependencies
 */
import { useEffect } from '@wordpress/element';
import { dispatch } from '@wordpress/data';
import { useNavigate } from 'react-router-dom';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Layout from '../../components/layout/Layout';
import PageHeading from '../../components/layout/PageHeading';
import OptionsForm from '../../components/options/OptionsForm';
import OptionsSubmit from '../../components/options/OptionsSubmit';
import jobStore from '../../data/options';
import { jobDefaultFormData } from '../../data/options/default-state';

export default function CreateOptions() {
    const navigate = useNavigate();

    const backToOptionsPage = () => {
        navigate('/options');
    };

    useEffect(() => {
        dispatch(jobStore).setFormData({
            ...jobDefaultFormData,
        });
    }, []);

    /**
     * Get Page Content - Title and New Options button.
     *
     * @return JSX.Element
     */
    const pageTitleContent = (
        <div className="">
            <div className="mr-3 mb-4">
                <button
                    onClick={backToOptionsPage}
                    className="text-gray-dark border-none"
                >
                    ← {__('Back to options', 'optionsbot')}
                </button>
            </div>
            <div className="text-left">
                <PageHeading text={__('Create New Options', 'optionsbot')} />
            </div>
        </div>
    );

    /**
     * Get Right Side Content - Create Options form data.
     */
    const pageRightSideContent = (
        <div className="mt-7 fixed invisible md:visible md:top-28 right-10 z-50">
            <OptionsSubmit />
        </div>
    );

    return (
        <Layout
            title={pageTitleContent}
            slug="create-job"
            hasRightSideContent={true}
            rightSideContent={pageRightSideContent}
        >
            <OptionsForm />
        </Layout>
    );
}
