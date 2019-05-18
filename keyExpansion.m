function [ new_key ] = keyExpansion( key, r_c )
%UNTITLED2 Summary of this function goes here
%   Detailed explanation goes here
% ,k2,k3,k4,k5,k6,k7,k8,k9,k10
% for the test purpose
round_key = [1 ,2 ,4 , 8 , 16,32,64,128,27,54];
rcon = [round_key(r_c);0;0;0];
[ s_box,i_s_box ] = SBox();
% get 4th column and make one shift

last_column = shiftColumn(key(:,4));
[ sub_column ] = [subsitute(last_column(1,1) ,s_box ) ; subsitute(last_column(2,1) ,s_box ) ; subsitute(last_column(3,1)  ,s_box ); subsitute(last_column(4,1) ,s_box ) ];

xorver = bitxor( sub_column,rcon);
xorver = bitxor(key(:,1),xorver);

new_key(:,1) = xorver;
new_key(:,2) =bitxor(new_key(:,1),key(:,2));
new_key(:,3) =bitxor(new_key(:,2),key(:,3));
new_key(:,4) =bitxor(new_key(:,3),key(:,4));
end


