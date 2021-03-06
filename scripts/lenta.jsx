var MessagePanel=React.createClass({
  render:function(){
    return(
        <div>
          <div>{this.props.msg_title}</div>
          <div>{this.props.msg_text}</div>
        </div>
    );
  }
});
var HeaderPanel=React.createClass({
  ajax_response_waiting:false,
  getInitialState:function(){
    return {messages:[],class_name:'HeaderPanel',};
  },
  ajaxRequest:function(){
    if(this.ajax_response_waiting)return;
    this.ajax_response_waiting=true;
    var url=this.props.url+'/'+this.props.user_id+'/'+this.state.messages.length;
    return $.ajax({
      url:url,
      dataType:'json',
      cache:false,
      timeout:10000,
      success:function(messages){
        var msgs=this.state.messages.concat(messages);
        this.setState({messages:msgs,class_name:'HeaderPanel is_active',});
      }.bind(this),
      error:function(req,stat,err){
        console.error(this.props.url,stat,err.toString());
      }.bind(this),
      complete:function(){
        this.ajax_response_waiting=false;
      }.bind(this)
    });
  },
  handleOnClick:function(e){
    if(this.state.messages.length>0){
      this.setState({messages:[],class_name:'HeaderPanel',});
      return;
    }
    this.req=this.ajaxRequest();
  },
  componentWillUnmount:function(){
    this.req.abort();
  },
  handleOnScroll:function(e){
    if(0==e.target.scrollHeight-e.target.clientHeight-e.target.scrollTop&&!this.ajax_response_waiting&&this.state.messages.length>0){
      this.req=this.ajaxRequest();
    }
  },
  render: function(){
    var msgs=[];
    this.state.messages.map(function(msg,i){
      var msg_title=msg.title;
      // set undefined title of first message
      if(i==0)msg_title=null;
      msgs.push(<MessagePanel msg_title={msg_title} msg_text={msg.text} key={msg.id} />);
    }.bind(this));
    return (
        <div className={this.state.class_name} onClick={this.handleOnClick} onScroll={this.handleOnScroll}>
          <div className="header_id">{this.props.user_id}</div>
          <div>{this.props.title}</div>
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
      rows.push(<HeaderPanel url="/ajax/getMessages" title={row.title} user_id={row.user_id} key={row.id} />);
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
  <LentaBox url="/ajax/getHeaders" />,
  document.getElementById('lenta')
);
