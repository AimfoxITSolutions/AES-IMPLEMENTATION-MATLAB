function [ chars ] = getCypherText( state )
%UNTITLED9 Summary of this function goes here
%   Detailed explanation goes here
s = 1;
e = 2;
for r = 1:4
    for c=1:4
       intn= dec2hex(state(c,r));
       chars(r,s:e) = intn;
       s = s + 2;
       e = e + 2;
    end
    s = 1;
    e = 2;
end
end

