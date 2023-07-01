/**
 * External dependencies
 */
import { useEffect, useState } from '@wordpress/element';
import { useNavigate } from 'react-router-dom';
import { faPlus } from '@fortawesome/free-solid-svg-icons';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Button from '../../components/button/Button';
import Layout from '../../components/layout/Layout';
import Table from '../../components/table/Table';
import TableLoading from '../../components/loading/TableLoading';
import PageHeading from '../../components/layout/PageHeading';
import { useSelect, useDispatch } from '@wordpress/data';
import store from '../../data/options';
import {
    useTableHeaderData,
    useTableRowData,
} from '../../components/options/use-table-data';
import SelectCheckBox from '../../components/options/SelectCheckBox';
import { Input } from '../../components/inputs/Input';
import { IOptions, IOptionsFilter } from '../../interfaces';

export default function OptionsPage() {
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [page, setPage] = useState(
        new URLSearchParams(location.search).get('pages') || 1
    );
    const searched = new URLSearchParams(location.search).get('s');
    const [search, setSearch] = useState<string>(
        typeof searched === 'string' ? searched : ''
    );
    const [checkedAll, setCheckedAll] = useState(false);

    const options: Array<IOptions> = useSelect(
        (select) => select(store).getOptions({}),
        []
    );
    const totalOptions: number = useSelect(
        (select) => select(store).getTotal(),
        []
    );
    const jobFilters: IOptionsFilter = useSelect(
        (select) => select(store).getFilter(),
        []
    );
    const loadingOptions: boolean = useSelect(
        (select) => select(store).getLoadingOptions(),
        []
    );

    useEffect(() => {
        dispatch(store).setFilters({
            ...jobFilters,
            page,
            search,
        });
    }, [page, search]);

    /**
     * Process search-bar, tab and pagination clicks.
     *
     * @param  pagePassed
     * @param  searchPassed
     * @return {void}
     */
    const processAndNavigate = (
        pagePassed: number = 0,
        searchPassed: string | null = null
    ) => {
        const pageData = pagePassed === 0 ? page : pagePassed;
        const searchData = searchPassed === '' ? search : searchPassed;
        navigate(`/options?pages=${pageData}&s=${searchData}`);
        setPage(pageData);

        dispatch(store).setFilters({
            ...jobFilters,
            page: pageData,
            search: searchData,
        });
    };

    // TODO: Implement this later.
    const [checked, setChecked] = useState<Array<number>>([]);
    const checkOptions = (jobId: number, isChecked = false) => {
        const optionsData = [];
        if (jobId === 0) {
            if (isChecked) {
                optionsData.push(...options.map((job) => job.id));
            }
            setChecked(optionsData);
        } else {
            setChecked([...checked, jobId]);
        }
    };

    /**
     * Handle Checked and unchecked.
     */
    useEffect(() => {
        if (options.length === checked.length && checked.length > 0) {
            setCheckedAll(true);
        } else {
            setCheckedAll(false);
        }
    }, [options, checked]);

    /**
     * Get Page Content - Title and New Options button.
     *
     * @return JSX.Element
     */
    const pageTitleContent = (
        <div className="flex">
            <div className="flex-6 mr-3">
                <PageHeading text={__('Options', 'optionsbot')} />
            </div>
            <div className="flex-1 text-left">
                <Button
                    text={__('New', 'optionsbot')}
                    type="primary"
                    icon={faPlus}
                    onClick={() => navigate('/options/new')}
                />
            </div>
        </div>
    );

    /**
     * Get Right Side Content - Options Search Input.
     *
     * @param  data
     */
    const pageRightSideContent = (
        <Input
            type="text"
            placeholder={__('Search Options…', 'optionsbot')}
            onChange={(data) => {
                setSearch(data.value);
                processAndNavigate(page, data.value);
            }}
            value={search}
            className="w-full md:w-80"
        />
    );

    const tableResponsiveColumns = ['sl', 'title', 'actions'];
    const tableHeaders = useTableHeaderData();
    const tableRows = useTableRowData(options, checked);

    return (
        <Layout
            title={pageTitleContent}
            slug="options"
            hasRightSideContent={true}
            rightSideContent={pageRightSideContent}
        >
            {loadingOptions ? (
                <TableLoading
                    headers={tableHeaders}
                    responsiveColumns={tableResponsiveColumns}
                    hasCheckbox={false}
                    count={5}
                />
            ) : (
                <>
                    {checked.length > 0 && (
                        <SelectCheckBox
                            checked={checked}
                            onChange={(response) => checkOptions()}
                        />
                    )}

                    <Table
                        headers={tableHeaders}
                        rows={tableRows}
                        totalItems={totalOptions}
                        perPage={10}
                        onCheckAll={(isChecked: boolean) => {
                            checkOptions(0, isChecked);
                            setCheckedAll(isChecked);
                        }}
                        responsiveColumns={tableResponsiveColumns}
                        checkedAll={checkedAll}
                        noDataMessage={__(
                            'Sorry !! No options found…',
                            'optionsbot'
                        )}
                        currentPage={
                            typeof page === 'number' ? parseInt(page) : 1
                        }
                        onChangePage={(page) =>
                            processAndNavigate(page, search)
                        }
                    />
                </>
            )}
        </Layout>
    );
}
