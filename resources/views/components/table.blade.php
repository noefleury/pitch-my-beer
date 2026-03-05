<div>
    <table class="table">
        <thead>
        <tr>
            @foreach($headers as $header)
                <th>{{ __($header) }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                @foreach($row as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<style>

    .table {

        border: 1px solid gray;
        border-radius: 10px;
        padding: 5px;

        thead {
            background-color: #80808047;

            tr > th {
                padding: 5px;
            }
        }

        tr {
            td {
                padding: 5px;

                &:not(:last-child) {
                    border-right: 1px solid #80808047;
                }
            }
        }

    }

</style>
