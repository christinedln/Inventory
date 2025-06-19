<div class="table-responsive">
    <table class="table table-hover history-table mb-0">
        <thead class="sticky-top">
            <tr>
                <th>Date</th>
                <th>Daily Revenue</th>
                <th>Entry Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
            <tr>
                <td>{{ $entry->date->format('M d, Y') }}</td>
                <td>₱ {{ number_format($entry->daily_revenue, 2) }}</td>
                <td>{{ $entry->created_at->format('h:i A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>