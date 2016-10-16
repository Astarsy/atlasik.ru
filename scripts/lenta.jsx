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
  getInitialState:function(){
    return {messages:[],cur_page:null,messages_count:null,messages_on_page:null,class_name:'HeaderPanel',};
  },
  handleOnClick:function(e){
    e.preventDefault();
    this.class_name+=' is_active';
    if(this.state.messages.length>0){
      this.setState({messages:[],cur_page:null,messages_count:null,messages_on_page:null,class_name:'HeaderPanel',});
      return;
    }
    this.req=$.ajax({
      url:this.props.url+'/'+this.props.user_id+'/'+this.state.cur_page,
      dataType:'json',
      cache:false,
      success:function(data){
        this.setState({messages:data.messages,cur_page:data.cur_page,messages_count:data.messages_count,messages_on_page:data.messages_on_page,class_name:'HeaderPanel is_active',});
      }.bind(this),
      error:function(req,stat,err){console.error(this.props.url,stat,err.toString());}.bind(this)
    });
  },
  componentWillUnmount:function(){
    this.req.abort();
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
        <div className={this.state.class_name} onClick={this.handleOnClick}>
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
      rows.push(<HeaderPanel url="/ajax/reactmessages" title={row.title} user_id={row.user_id} key={row.id} />);
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
