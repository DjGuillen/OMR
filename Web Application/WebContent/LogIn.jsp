<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<%@page import="DAO.*" %>
<%@page import="KLASE.*" %>
<%@ page import="java.security.MessageDigest" %>
<%@ page import="java.security.NoSuchAlgorithmException" %>
<%@ page import="java.util.Formatter" %>
<%@ page import="java.math.BigInteger" %>
<%@ page import="java.sql.*" %>

<%
if (request.getParameter("submit")!=null){
	
	String username=request.getParameter("username");

	Connection c=DAL.connect();	
    Statement stmt = c.createStatement();
    ResultSet rs;

    rs = stmt.executeQuery("SELECT username FROM korisnici");
      while ( rs.next() ) {
        if(username.equals(rs.getString("username"))){
        	try{
        		MessageDigest cript = MessageDigest.getInstance("SHA-1");
        	    cript.reset();
        	    cript.update(request.getParameter("password").getBytes("utf8"));
        	    String password=new BigInteger( 1, cript.digest() ).toString(16);	
        		 
        		    Statement stmt1 = c.createStatement();
        		    ResultSet rs1;
        		    
        		    rs1 = stmt1.executeQuery("SELECT password FROM korisnici where username='" + username + "'");
        		    rs1.next(); 
        		    if(password.equals(rs1.getString(1))){
        		    	out.println("Uspjesno ste logovani");
        		    	response.sendRedirect("Main.jsp");
        		    }
        		    else{
        		    	//Pogresna sifra
        		    }
       
        		}
        	    	
        	    catch (NoSuchAlgorithmException e){
        	    	//handle
        	    }
        	
        }
        else{
        	//out.println("pogresno korisnicko ime");
        }
	}
	
}
%>
<div id="box">
<div class="elements">
<div class="avatar"></div>
<form action="" method="post">
<input type="text" name="username" class="username"/>
<input type="password" name="password" class="password"/>
<input type="submit" name="submit" class="submit" value="Prijavi se" />
</form>
</div>
</div>
</body>
</html>