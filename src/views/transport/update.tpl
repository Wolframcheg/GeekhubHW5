<h2>Update Transport #{{model.getId}}</h2>

{% include 'transport/_form.tpl' %}

<h2>Properties</h2>
{% if transportProperties is null %}
<p>This transport doesn't have any properties</p>
{% else %}
{% for item in transportProperties %}
<p>{{item.getType}} - {{item.getName}} <a href="/transport/delete-property/{{model.getId}}/{{item.getId}}">Delete</a>
<p>
    {% endfor %}
    {% endif %}

    {% if propDiff is empty %}
<p>Doesn have available Property for this Transport</p>
{% else %}
<form method="POST" action="/transport/add-property">
    <input type="hidden" name="id_transport" value="{{model.getId}}">
    <input type="hidden" name="location" value="/transport/update/{{model.getId}}">
    <select name="id_properties">
        {% for item in propDiff %}
        <option value="{{item.id}}">{{item.type}} - {{item.name}}</option>
        {% endfor %}
    </select>
    <button type="submit">Add</button>
</form>
{% endif %}