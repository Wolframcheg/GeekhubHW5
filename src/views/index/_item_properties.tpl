<h2>Properties</h2>
<a href="/properties/create/">create Properties</a><br><br>
{% if models is empty %}
<p>No Data</p>
{% else %}
<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>type</th>
        <th></th>
    </tr>
    {% for item in models %}
    <tr>
        <td>{{item.getId}}</td>
        <td>{{item.getName}}</td>
        <td>{{item.getType}}</td>
        <td><a href="/properties/update/{{item.getId}}">update</a> |
            <a href="/properties/delete/{{item.getId}}">delete</a>
        </td>
    </tr>
    {% endfor %}
</table>
{% endif %}