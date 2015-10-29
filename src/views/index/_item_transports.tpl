<h2>Transports</h2>
<a href="/transport/create/">create Transport</a><br><br>
<table border="1">
    <tr>
        <th>id</th>
        <th>vendor</th>
        <th>model</th>
        <th>max_speed</th>
        <th></th>
    </tr>
    {% for item in models %}
    <tr><td>{{item.getId}}</td>
        <td>{{item.getVendor}}</td>
        <td>{{item.getModel}}</td>
        <td>{{item.getMaxSpeed}}</td>
        <td><a href="/transport/update/{{item.getId}}">update</a> |
            <a href="/transport/delete/{{item.getId}}">delete</a>
        </td>
    </tr>
    {% endfor %}
</table>