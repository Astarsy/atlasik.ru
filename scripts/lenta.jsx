var HeaderPanel=React.createClass({
  render: function(){
    return (
        <div>{this.props.title}</div>
    );
  }
});

var LentaBox=React.createClass({
  getInitialState:function(){
    return {
      data:[
        {id:"1",title:"First title",text:"First text content"},
        {id:"2",title:"Second title",text:"Second text content"},
        {id:"3",title:"Third title",text:"Third text content"},
      ]
    };
  },
  render: function(){
    var rows=[];
    this.state.data.map(function(row){
      rows.push(<HeaderPanel title={row.title} key={row.id} />);
    });
    return (
        <div>
          <h4>Форум</h4>
          {rows}
          <h4>***</h4>
        </div>
    );
  }
});

ReactDOM.render(
  <LentaBox />,
  document.getElementById('lenta')
);
