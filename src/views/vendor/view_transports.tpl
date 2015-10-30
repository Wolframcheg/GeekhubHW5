<h2>Transports by vendor #{{model.getName}}</h2>

{% for item in transports %}
<p>Transport : #{{item.getModel}}</p>
{% endfor %}

{% if transports is null %}
<p>This vendor not have Transports</p>
{% endif %}

<a href="/">Main page</a>