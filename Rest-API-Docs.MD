## REST API Documentation

Details about the REST API documentation of the plugin.

---
#### Options Lists API
**URL** - http://localhost/wpex/wp-json/options-bot/v1/options/SPY
**Method** - `GET`
**Middleware** - WordPress user logged in.
**Parameters** -
```
exp_date=2023-05-01
number_strike=5
```
**Full Endpoint** with all of the supported params -
http://localhost/wpex/wp-json/options-bot/v1/options/SPY?exp_date=2023-05-01&number_strike=5

**API Response**
```json
[
    {
        "id": "1",
        "symbol": "SPY",
        "slug": "SPY_20230526_415_20230526",
        "exp_date": "05/26/2023",
        "trace_date": "05/26/2023",
        "strike_price": 415,
        "up90_call_pct": null,
        "up90_put_pct": true,
        "contract_symbol_call": "SPY_052623C415",
        "pre_close_call": 1.32,
        "open_call": 1.32,
        "low_call": 1.53,
        "high_call": 5.74,
        "avg_call": 3.6350000000000002,
        "last_close_call": 1.32,
        "close_call": 4.96,
        "ov_call": 29433,
        "iv_call": 11.327,
        "volume_call": 52313,
        "change_call": "73.39",
        "daily_change_call": "275.76",
        "pct_open_low_call": "15.91",
        "pre_close_put": 1.75,
        "contract_symbol_put": "SPY_052623P415",
        "open_put": 1.75,
        "low_put": 0.01,
        "high_put": 1.14,
        "avg_put": 0.575,
        "close_put": 0.01,
        "last_close_put": 1.75,
        "ov_put": 23465,
        "iv_put": 11.327,
        "volume_put": 205563,
        "change_put": "-17,400.00",
        "daily_change_put": "-99.43",
        "pct_open_low_put": "-99.43"
    }
]
```


#### Orders Lists API
**URL** - http://localhost/wpex/wp-json/options-bot/v1/orders
**Method** - `GET`
**Middleware** - WordPress user logged in.
**Parameters** -
```
page=1
per_page=20
symbol=SPY
fromDate=2023-05-26
toDate=2023-05-31
options_type=CALL
status=open
```
**Full Endpoint** with all of the supported params -
http://localhost/wpex/wp-json/options-bot/v1/orders/page=1&per_page=20&order_by=&order=&symbol=&fromDate=2023-05-26&toDate=&options_type=&status=&manually=&simulate=

**API Response**
```json
[
    {
        "id": "1",
        "symbol": "SPY",
        "action": "buy_to_open",
        "market_type": "LIMIT",
        "contract_symbol": "SPY_052623P414",
        "stop_loss": 0.125,
        "expiration_date": "05/26/2023",
        "strike_price": 414,
        "options_type": "PUT",
        "order_type": "exit",
        "entry_datetime": "05/26/2023 07:02:17",
        "exit_datetime": "05/26/2023 07:25:10",
        "gain_loss": 0.12,
        "status": "closed",
        "number_share": 24,
        "entry_price": "0.25",
        "exit_price": "0.11",
        "total_gain_loss": 0,
        "current_price": "0.13",
        "entry_order_id": 6236468737,
        "exit_order_id": 6236657827,
        "entry_order_status": "FILLED",
        "exit_order_status": "FILLED",
        "entry_order_price": 0.25,
        "exit_order_price": 0.37,
        "max_gain": 0.40,
        "start_track": true,
        "track_gain": "0.16",
        "logic": "BEGIN",
        "entry_order_datetime": "05/26/2023 07:02:47",
        "exit_order_datetime": "05/26/2023 07:25:11"
    }
]
```