/**
 * External dependencies
 */
import { useSelect } from '@wordpress/data';
import { useNavigate, useParams } from 'react-router-dom';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Layout from '../../components/layout/Layout';
import PageHeading from '../../components/layout/PageHeading';
import OptionsForm from '../../components/options/OptionsForm';
import OptionsSubmit from '../../components/options/OptionsSubmit';
import jobStore from '../../data/options';
import { IOptions } from '../../interfaces';

export default function EditOptions() {
    const navigate = useNavigate();
    const { id } = useParams();

    const backToOptionsPage = () => {
        navigate('/options');
    };

    const jobDetails: IOptions = useSelect(
        (select) => select(jobStore).getOptionsDetail(id),
        []
    );

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
                <PageHeading text={__('Edit Options', 'optionsbot')} />
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
            slug="edit-job"
            hasRightSideContent={true}
            rightSideContent={pageRightSideContent}
        >
            <OptionsForm job={jobDetails} />
        </Layout>
    );
}
