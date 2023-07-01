/**
 * External dependencies.
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
// import { Input } from '../inputs/Input';
import Badge from '../badge/Badge';
import ListItemMenu from './ListItemMenu';
import { ITableHeader, ITableRow } from '../table/TableInterface';
import { capitalize } from '../../utils/StringHelper';

export const useTableHeaderData = (): ITableHeader[] => {
    return [
        {
            key: 'sl',
            title: 'Sl',
            className: '',
        },
        {
            key: 'title',
            title: __('Options', 'optionsbot'),
            className: '',
        },
        {
            key: 'options_type',
            title: __('Options type', 'optionsbot'),
            className: '',
        },
        {
            key: 'company',
            title: __('Company', 'optionsbot'),
            className: '',
        },
        {
            key: 'status',
            title: __('Status', 'optionsbot'),
            className: '',
        },
        {
            key: 'actions',
            title: __('Action', 'optionsbot'),
            className: '',
        },
    ];
};

export const useTableRowData = (options = [], checked: number[]): ITableRow[] => {
    const rowsData: ITableRow[] = [];

    options.forEach((row, index) => {
        rowsData.push({
            id: row.id,
            cells: [
                {
                    key: 'sl',
                    value: (
                        // <Input
                        //     value={checked.includes(row.id) ? '1' : '0'}
                        //     type="checkbox"
                        //     //  onChange={() => checkOptions(row.id)}
                        // />
                        <>
                            <b>{index + 1}</b>
                        </>
                    ),
                    className: '',
                },
                {
                    key: 'title',
                    value: row.title,
                    className: '',
                },
                {
                    key: 'options_type',
                    value: row.options_type?.name,
                    className: '',
                },
                {
                    key: 'company',
                    value: (
                        <div className="flex">
                            <div className="flex-6">
                                <img
                                    src={row.company?.avatar_url}
                                    alt=""
                                    className="mr-3 w-7 rounded-full"
                                />
                            </div>
                            <div className="flex-6">{row.company?.name}</div>
                        </div>
                    ),
                    className: '',
                },
                {
                    key: 'status',
                    value: (
                        <Badge
                            text={capitalize(row.status)}
                            type={
                                row.status === 'published'
                                    ? 'success'
                                    : 'default'
                            }
                            hasIcon={true}
                        />
                    ),
                    className: '',
                },
                {
                    key: 'actions',
                    value: (
                        <div>
                            <ListItemMenu job={row} />
                        </div>
                    ),
                    className: '',
                },
            ],
        });
    });

    return rowsData;
};
