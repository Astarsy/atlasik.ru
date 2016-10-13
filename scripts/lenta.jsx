var MessagePanel=React.createClass({
  render:function(){
    return(
        <div>
          {this.props.msg_text}
        </div>
    );
  }
});
var HeaderPanel=React.createClass({
  getInitialState:function(){
    return {data:[]};
  },
  handleOnClick:function(e){
    if(this.state.data.length>0){
      this.setState({data:[]});
      return;
    }
    var h_id=e.target.getElementsByClassName('header_id')[0].innerHTML.toString();
    this.req=$.ajax({
      url:this.props.url+'/'+h_id,
      dataType:'json',
      cache:false,
      success:function(data){
        this.setState({data:data});
      }.bind(this),
      error:function(req,stat,err){console.error(this.props.url,stat,err.toString());}.bind(this)
    });
  },
  componentWillUnmount:function(){
    this.req.abort();
  },
  render: function(){
    var msgs=[];
    this.state.data.forEach(function(msg){
      msgs.push(<MessagePanel msg_text={msg.text} key={msg.id} />);
    });
    return (
        <div onClick={this.handleOnClick}>
          <span className="header_id">{this.props.user_id}</span>
          <span>{this.props.title}</span>
          <div>
            {msgs}
          </div>
        </div>
    );
  }
});

var LentaBox=React.createClass({
  getInitialState:function(){
    return {data:[]};
  },
  componentDidMount:function(){
    this.req=$.ajax({
      url:this.props.url,
      dataType:'json',
      cache:false,
      success:function(data){
        this.setState({data:data});
      }.bind(this),
      error:function(req,stat,err){console.error(this.props.url,stat,err.toString());}.bind(this)
    });
  },
  componentWillUnmount:function(){
    this.req.abort();
  },
  render: function(){
    var rows=[];
    this.state.data.map(function(row){
      rows.push(<HeaderPanel url="/ajax/messages" title={row.title} user_id={row.user_id} key={row.id} />);
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
  <LentaBox url="/ajax/getmsgheaders" />,
  document.getElementById('lenta')
);
