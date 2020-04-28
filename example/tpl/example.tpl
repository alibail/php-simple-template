<html>
<head>
  <title>Basic Usage Example Template</title>
</head>
<body>
  <h2>{{pageTitle}}</h2>
  <p>This is an example of how to use the template class, this text exists in the template as it is static
    text and not expected to change.</p>
  <p>{{pageTextExample}}</p>
  <p>Below this is a table, showing an example of how to use 'sub templates' for iteration.</p>
  <table>
    <tr>
      <th>Column 1</th>
      <th>Column 2</th>
    </tr>
    [[Row]]<tr>
      <td>{{iCounter}}</td>
      <td>{{iCounterTwo}}</td>
    </tr>[[/Row]]
  </table>
</body>
</html>
