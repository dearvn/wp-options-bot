/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { useNavigate } from 'react-router-dom';

/**
 * Internal dependencies.
 */
import Button from '../button/Button';


const Dashboard = () => {
    const navigate = useNavigate();
    return (
        <div className="dashboard mx-8">
            <div className="card p-5">
                <h3 className="font-medium text-lg">
                    {__('Dashboard', 'optionsbot')}
                </h3>
                <p>
                    {__('Edit Dashboard component at ', 'optionsbot')}
                    <code>src/components/Dashboard.jsx</code>
                </p>

                <div className="mt-4">
                    <Button
                        type="primary"
                        style={{ backgroundColor: '#00a0d2' }}
                        text={__('View Options', 'optionsbot')}
                        onClick={() => navigate('/options')}
                    />
                </div>
            </div>

            <div className="card p-5">
            <div className="canvas-editor"></div>
            </div>

        </div>
    );
};

export default Dashboard;
