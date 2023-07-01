/**
 * External dependencies.
 */
import { createReduxStore } from '@wordpress/data';

/**
 * Internal dependencies.
 */
import reducer from './reducer';
import actions from './actions';
import selectors from './selectors';
import controls from './controls';
import resolvers from './resolvers';

const orderStore = createReduxStore('options-bot/order', {
    reducer,
    actions,
    selectors,
    controls,
    resolvers,
});

export default orderStore;
