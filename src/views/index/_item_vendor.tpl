<h2>Vendors</h2>
<a href="/vendor/create/">create Vendor</a><br><br>
{% if models is empty %}
<p>No Data</p>
{% else %}
<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>
        <th></th>
    </tr>
    {% for item in models %}
    <tr>
        <td>{{item.getId}}</td>
        <td>{{item.getName}}</td>
        <td><a href="/vendor/update/{{item.getId}}">update</a> |
            <a href="/vendor/delete/{{item.getId}}">delete</a> |
            <a href="/vendor/view-transports/{{item.getId}}">view Transports</a> |
        </td>
    </tr>
    {% endfor %}
</table>
{% endif %}