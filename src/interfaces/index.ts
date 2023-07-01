export interface IAction {
    /**
     * Action type string key name.
     */
    type: string;
}

export interface IResponseGenerator {
    config?: any;
    data?: any;
    headers?: any;
    request?: any;
    status?: number;
    statusText?: string;
}

// Options types
export * from './options';

// Order types
export * from './order';
